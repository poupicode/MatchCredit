<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Parseur d'expressions arithmétiques maison. Jamais d'eval()/create_function().
 * Supporte : nombres, identifiants (résolus contre $variables uniquement),
 * opérateurs + - * / ^, parenthèses, et un set fermé de fonctions whitelistées.
 */
class MC_Tools_Formula_Parser {

	/** @var string */
	private $expression;

	/** @var array<int,array{type:string,value:string}> */
	private $tokens = array();

	/** @var int */
	private $pos = 0;

	/** @var array<string,float> */
	private $variables = array();

	const ALLOWED_FUNCTIONS = array( 'min', 'max', 'abs', 'round', 'sqrt' );

	/**
	 * @throws InvalidArgumentException Si l'expression est syntaxiquement invalide.
	 */
	public function __construct( string $expression ) {
		$this->expression = $expression;
		$this->tokenize();
	}

	/**
	 * @param array<string,float> $variables
	 * @throws InvalidArgumentException Si une variable référencée n'est pas déclarée.
	 */
	public function evaluate( array $variables ): float {
		$this->variables = $variables;
		$this->pos       = 0;

		$result = $this->parseExpression();

		if ( $this->pos !== count( $this->tokens ) ) {
			throw new InvalidArgumentException( 'Expression invalide : caractères inattendus en fin de formule.' );
		}

		return $result;
	}

	/**
	 * Valide la formule sans l'évaluer : vérifie la syntaxe et que tous les
	 * identifiants référencés appartiennent à $allowed_identifiers.
	 *
	 * @param string[] $allowed_identifiers
	 */
	public static function validate( string $expression, array $allowed_identifiers ): bool {
		$parser = new self( $expression );

		foreach ( $parser->tokens as $token ) {
			if ( 'identifier' === $token['type']
				&& ! in_array( $token['value'], self::ALLOWED_FUNCTIONS, true )
				&& ! in_array( $token['value'], $allowed_identifiers, true )
			) {
				throw new InvalidArgumentException( sprintf( 'Variable inconnue dans la formule : "%s".', $token['value'] ) );
			}
		}

		// Évaluation à blanc avec des valeurs neutres pour vérifier la syntaxe.
		$dummy = array_fill_keys( $allowed_identifiers, 1.0 );
		$parser->evaluate( $dummy );

		return true;
	}

	private function tokenize(): void {
		$len = strlen( $this->expression );
		$i   = 0;

		while ( $i < $len ) {
			$char = $this->expression[ $i ];

			if ( ctype_space( $char ) ) {
				++$i;
				continue;
			}

			if ( ctype_digit( $char ) || '.' === $char ) {
				$start = $i;
				while ( $i < $len && ( ctype_digit( $this->expression[ $i ] ) || '.' === $this->expression[ $i ] ) ) {
					++$i;
				}
				$this->tokens[] = array(
					'type'  => 'number',
					'value' => substr( $this->expression, $start, $i - $start ),
				);
				continue;
			}

			if ( ctype_alpha( $char ) || '_' === $char ) {
				$start = $i;
				while ( $i < $len && ( ctype_alnum( $this->expression[ $i ] ) || '_' === $this->expression[ $i ] ) ) {
					++$i;
				}
				$this->tokens[] = array(
					'type'  => 'identifier',
					'value' => substr( $this->expression, $start, $i - $start ),
				);
				continue;
			}

			if ( in_array( $char, array( '+', '-', '*', '/', '^', '(', ')', ',' ), true ) ) {
				$this->tokens[] = array(
					'type'  => 'op',
					'value' => $char,
				);
				++$i;
				continue;
			}

			throw new InvalidArgumentException( sprintf( 'Caractère non autorisé dans la formule : "%s".', $char ) );
		}
	}

	private function peek(): ?array {
		return $this->tokens[ $this->pos ] ?? null;
	}

	private function consume( ?string $expectedValue = null ): array {
		$token = $this->peek();
		if ( null === $token ) {
			throw new InvalidArgumentException( 'Expression invalide : fin inattendue.' );
		}
		if ( null !== $expectedValue && $token['value'] !== $expectedValue ) {
			throw new InvalidArgumentException( sprintf( 'Expression invalide : "%s" attendu.', $expectedValue ) );
		}
		++$this->pos;
		return $token;
	}

	// expression := term (('+' | '-') term)*
	private function parseExpression(): float {
		$value = $this->parseTerm();

		while ( ( $token = $this->peek() ) && in_array( $token['value'], array( '+', '-' ), true ) ) {
			$this->consume();
			$right = $this->parseTerm();
			$value = '+' === $token['value'] ? $value + $right : $value - $right;
		}

		return $value;
	}

	// term := factor (('*' | '/') factor)*
	private function parseTerm(): float {
		$value = $this->parseFactor();

		while ( ( $token = $this->peek() ) && in_array( $token['value'], array( '*', '/' ), true ) ) {
			$this->consume();
			$right = $this->parseFactor();
			if ( '*' === $token['value'] ) {
				$value *= $right;
			} else {
				if ( 0.0 === (float) $right ) {
					throw new InvalidArgumentException( 'Division par zéro dans la formule.' );
				}
				$value /= $right;
			}
		}

		return $value;
	}

	// factor := unary ('^' factor)?  (exponentiation right-associative)
	private function parseFactor(): float {
		$value = $this->parseUnary();

		if ( ( $token = $this->peek() ) && '^' === $token['value'] ) {
			$this->consume();
			$exponent = $this->parseFactor();
			return $value ** $exponent;
		}

		return $value;
	}

	// unary := ('-' unary) | primary
	private function parseUnary(): float {
		if ( ( $token = $this->peek() ) && '-' === $token['value'] ) {
			$this->consume();
			return -1 * $this->parseUnary();
		}

		return $this->parsePrimary();
	}

	// primary := number | identifier | identifier '(' args ')' | '(' expression ')'
	private function parsePrimary(): float {
		$token = $this->peek();

		if ( null === $token ) {
			throw new InvalidArgumentException( 'Expression invalide : fin inattendue.' );
		}

		if ( 'number' === $token['type'] ) {
			$this->consume();
			return (float) $token['value'];
		}

		if ( 'identifier' === $token['type'] ) {
			$this->consume();
			$name = $token['value'];

			if ( ( $next = $this->peek() ) && '(' === $next['value'] ) {
				return $this->parseFunctionCall( $name );
			}

			if ( ! array_key_exists( $name, $this->variables ) ) {
				throw new InvalidArgumentException( sprintf( 'Variable non déclarée : "%s".', $name ) );
			}

			return (float) $this->variables[ $name ];
		}

		if ( '(' === $token['value'] ) {
			$this->consume( '(' );
			$value = $this->parseExpression();
			$this->consume( ')' );
			return $value;
		}

		throw new InvalidArgumentException( 'Expression invalide.' );
	}

	private function parseFunctionCall( string $name ): float {
		if ( ! in_array( $name, self::ALLOWED_FUNCTIONS, true ) ) {
			throw new InvalidArgumentException( sprintf( 'Fonction non autorisée : "%s".', $name ) );
		}

		$this->consume( '(' );
		$args = array( $this->parseExpression() );

		while ( ( $token = $this->peek() ) && ',' === $token['value'] ) {
			$this->consume();
			$args[] = $this->parseExpression();
		}

		$this->consume( ')' );

		switch ( $name ) {
			case 'min':
				return min( $args );
			case 'max':
				return max( $args );
			case 'abs':
				return abs( $args[0] );
			case 'round':
				return isset( $args[1] ) ? round( $args[0], (int) $args[1] ) : round( $args[0] );
			case 'sqrt':
				if ( $args[0] < 0 ) {
					throw new InvalidArgumentException( 'sqrt() : argument négatif.' );
				}
				return sqrt( $args[0] );
		}

		// Inatteignable grâce à la whitelist ci-dessus.
		throw new InvalidArgumentException( 'Fonction non implémentée.' );
	}
}
