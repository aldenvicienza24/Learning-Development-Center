import { mkdir, readFile, writeFile } from 'node:fs/promises';
import { transform } from 'lightningcss';

const sourcePath = new URL('../resources/css/public-theme.css', import.meta.url);
const outputPath = new URL('../public/css/public-theme.css', import.meta.url);
const source = await readFile(sourcePath);
const result = transform({
    filename: 'public-theme.css',
    code: source,
    minify: true,
});

await mkdir(new URL('../public/css/', import.meta.url), { recursive: true });
await writeFile(outputPath, result.code);
