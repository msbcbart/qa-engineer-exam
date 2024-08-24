import { test, expect } from '@playwright/test';

test('display product page UI elements correctly', async ({ page }) => {
    // Spell Check
    const checkSpelling = new Set([
        'Products',
        'Create',
        'Name',
        'Category',
        'Description',
        'Action',
        'Electronics',
        'Clothing',
        'Home & Furnitures',
        'Beauty & Personal Care',
        'Sports & Outdoors'
    ]);
    
    // Login
    await page.goto('http://localhost:8000/login');
    await page.fill('input[name="email"]', 'goldner.earl@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button:has-text("Sign In")');
    await expect(page).toHaveURL('http://localhost:8000/product');
      
    // Visit the product page
    await page.goto('http://localhost:8000/product');

    // Navigation bar visibility
    await expect(page.locator('nav.main-header.navbar')).toBeVisible();
    await expect(page.locator('i.fas.fa-bars')).toBeVisible();

    // Content header and button
    await expect(page.locator('div.content-header')).toBeVisible();
    await expect(page.locator('h1')).toHaveText('Products');
    await expect(page.locator('a.btn.btn-primary.btn-round.float-right')).toBeVisible();
    await expect(page.locator('a.btn.btn-primary.btn-round.float-right')).toHaveText('Create');

    // Table visibility and headers
    await expect(page.locator('table')).toBeVisible();
    const headers = ['Name', 'Category', 'Description'];
    for (let i = 0; i < headers.length; i++) {
        const headerText = await page.locator(`thead th`).nth(i).textContent();
        if (!checkSpelling.has(headerText.trim())) {
            console.error(`Misspelled header: "${headerText}"`);
        }
        expect(checkSpelling.has(headerText.trim())).toBe(true);
    }

    // Rows and content
    const rows = page.locator('tbody tr');
    await expect(rows).toHaveCount(5);

    const firstRow = rows.nth(0);
    await expect(firstRow.locator('td').nth(0)).toHaveText('quibusdam');
    await expect(firstRow.locator('td').nth(1)).toHaveText('Electonics');
    await expect(firstRow.locator('td').nth(2)).toHaveText(/Alice, rather doubtfully, as she fell past it. 'Well!/);
    
    const misspelledWords = [];
    
    // Check category for spelling error
    for (let i = 0; i < 5; i++) {
        const row = rows.nth(i);
        const categoryCell = row.locator('td').nth(1);
        const categoryText = await categoryCell.textContent();

        if (!checkSpelling.has(categoryText.trim())) {
            misspelledWords.push(categoryText.trim());
        }
    }
    
    if (misspelledWords.length > 0) {
        console.error('Misspelled category:', misspelledWords.join(', '));
    }
});

