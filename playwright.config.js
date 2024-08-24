import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
  projects: [
    { name: 'firefox', use: { ...devices['Desktop Firefox'] } },
    { name: 'Google Chrome', use: { ...devices['Desktop Chrome'] } },
  ],
  testDir: './tests',
  timeout: 30000,
  expect: { timeout: 5000 },
});

