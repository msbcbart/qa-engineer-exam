import { test, expect } from '@playwright/test';

test('login test', async ({ page }) => {
    await page.goto('http://localhost:8000/login');
    await page.fill('input[name="email"]', 'goldner.earl@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button:has-text("Sign In")');
    await expect(page).toHaveURL('http://localhost:8000/product');
});
