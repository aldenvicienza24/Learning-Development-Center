const fs = require('fs');
const path = require('path');

const dir = 'c:\\PROJECT\\web-uisi\\resources\\views';

[1,2,3,4,5,6,'a','b'].forEach(i => {
    const filePath = path.join(dir, `detail${i}.blade.php`);
    if (!fs.existsSync(filePath)) return;
    
    let content = fs.readFileSync(filePath, 'utf8');

    // Add missing </a> before <!-- Language Switcher Button -->
    // In detail1, it looks like:
    // Hubungi Kami
    // 
    // <!-- Language Switcher Button -->
    
    content = content.replace(/Hubungi Kami(\s*)<!-- Language Switcher Button -->/g, 'Hubungi Kami\n                </a>\n$1<!-- Language Switcher Button -->');
    content = content.replace(/Contact Us(\s*)<!-- Language Switcher Button -->/g, 'Contact Us\n                </a>\n$1<!-- Language Switcher Button -->');

    fs.writeFileSync(filePath, content, 'utf8');
    console.log(`Fixed missing </a> in detail${i}`);
});
