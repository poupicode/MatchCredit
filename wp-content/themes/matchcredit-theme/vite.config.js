import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
	build: {
		outDir: 'assets',
		emptyOutDir: false,
		watch: process.argv.includes('--watch') ? {} : null,
		rollupOptions: {
			input: {
				style: resolve(__dirname, 'src/scss/main.scss'),
				main: resolve(__dirname, 'src/js/main.js'),
			},
			output: {
				entryFileNames: 'js/[name].js',
				assetFileNames: (info) =>
					info.name && info.name.endsWith('.css') ? 'css/main.css' : 'assets/[name][extname]',
			},
		},
	},
});
