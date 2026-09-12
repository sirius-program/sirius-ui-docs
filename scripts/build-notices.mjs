import { existsSync, readFileSync, readdirSync, writeFileSync } from 'node:fs';
import { dirname, join, resolve } from 'node:path';

const roots = ['flatpickr', 'filepond', 'tom-select', '@tiptap/core', '@tiptap/starter-kit'];
const seen = new Set();
const notices = ['Third-party notices for the locally bundled integration proofs.\n'];

function collect(name, from) {
    let cursor = from;
    let location;
    while (true) {
        const candidate = join(cursor, 'node_modules', name);
        if (existsSync(join(candidate, 'package.json'))) {
            location = candidate;
            break;
        }
        const parent = dirname(cursor);
        if (parent === cursor) throw new Error(`Cannot locate installed dependency: ${name}`);
        cursor = parent;
    }
    const pkg = JSON.parse(readFileSync(join(location, 'package.json'), 'utf8'));
    const identity = `${pkg.name}@${pkg.version}`;
    if (seen.has(identity)) return;
    seen.add(identity);
    const files = readdirSync(location).filter((file) => /^(licen[cs]e|copying|notice)(\.|$)/i.test(file));
    notices.push(`\n===== ${identity} (${pkg.license}) =====\n`);
    if (!files.length && name === '@orchidjs/sifter') {
        notices.push(readFileSync(join(location, 'README.md'), 'utf8').split('## License')[1]);
        notices.push(readFileSync('node_modules/tom-select/LICENSE', 'utf8'));
    } else if (!files.length && name === '@orchidjs/unicode-variants') {
        notices.push(readFileSync('scripts/licenses/unicode-variants-1.1.2.txt', 'utf8'));
    } else if (!files.length) {
        throw new Error(`Missing license notice: ${identity}`);
    }
    for (const file of files) notices.push(readFileSync(join(location, file), 'utf8'));
    for (const dependency of Object.keys(pkg.dependencies ?? {})) collect(dependency, location);
}

for (const name of roots) collect(name, resolve('.'));
writeFileSync('public/third-party-notices.txt', notices.join('\n'));
