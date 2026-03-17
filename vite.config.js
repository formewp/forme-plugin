import { defineConfig } from 'vite'
import { existsSync, unlinkSync, writeFileSync } from 'fs'
import { resolve } from 'path'

const hotFile = resolve(__dirname, 'hot')

const cleanup = () => {
    if (existsSync(hotFile)) {
        unlinkSync(hotFile)
    }
}

process.on('exit', cleanup)
process.on('SIGINT', () => { cleanup(); process.exit(0) })
process.on('SIGTERM', () => { cleanup(); process.exit(0) })

function hotFilePlugin() {
    return {
        name: 'vite-plugin-hot-file',
        configureServer(server) {
            server.httpServer?.once('listening', () => {
                const address = server.httpServer?.address()
                const port = typeof address === 'object' && address !== null
                    ? address.port
                    : 5173
                writeFileSync(hotFile, `http://localhost:${port}`)
            })
        },
    }
}

export default defineConfig(({command}) => ({
    base: command === 'build'
        ? '/wp-content/plugins/replace-me-plugin/assets/dist/'
        : '/',
    resolve: {
        preserveSymlinks: true
    },
    build: {
        outDir: 'assets/dist',
        assetsDir: '',
        manifest: true,
        emptyOutDir: true,
        rollupOptions: {
            input: ['assets/src/js/app.js', 'assets/src/css/app.css'],
        },
    },
    plugins: [
        hotFilePlugin(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: ['**/wp-test/**'],
        },
    },
}))
