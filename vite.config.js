import path from 'path'
import { defineConfig } from 'vite'
import liveReload from 'vite-plugin-live-reload'

export default defineConfig({
  plugins: [
    liveReload(__dirname + '/theme/**/*.php')
  ],
  root: 'src',
  base: process.env.APP_ENV === 'development'
    ? '/'
    : '/dist/',
  build: {
    outDir: path.resolve(__dirname, '/dist'),
    emptyOutDir: true,
    manifest: true,
    target: 'es2018',
    rollupOptions: {
      input: '/main.js'
    }
  },
  server: {
    cors: true,
    strictPort: true,
    port: 3000
  }
})
