const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

(async () => {
    const args = process.argv.slice(2);
    if (args.length < 2) {
        console.error('Usage: node generateImage.js <htmlFilePath> <imageOutputPath>');
        process.exit(1);
    }

    const htmlFilePath = args[0];
    const imageOutputPath = args[1];

    console.log(`Starting image generation process...`);
    console.log(`HTML file: ${htmlFilePath}`);
    console.log(`Output image: ${imageOutputPath}`);

    try {
        if (!fs.existsSync(htmlFilePath)) {
            throw new Error(`HTML file not found: ${htmlFilePath}`);
        }
        const htmlContent = fs.readFileSync(htmlFilePath, 'utf8');
        const browser = await puppeteer.launch({
            headless: "new",
            executablePath: 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', // Adjust this path if needed
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage'
            ]
        });
        const page = await browser.newPage();
        await page.setContent(htmlContent, { waitUntil: 'networkidle0' });
        await page.setViewport({ width: 2480, height: 350});
        const outputDir = path.dirname(imageOutputPath);
        if (!fs.existsSync(outputDir)) {
            fs.mkdirSync(outputDir, { recursive: true });
        }

        await page.screenshot({ path: imageOutputPath, type: 'jpeg', quality: 90, fullPage: true });

        await browser.close();

    } catch (error) {
        process.exit(1);
    }
})();
