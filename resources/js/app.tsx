/// <reference types="vite/client" />
import React from 'react';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { CssBaseline, ThemeProvider, createTheme } from '@mui/material';

const theme = createTheme({
    palette: {
        primary: { main: '#1976d2' },
        background: { default: '#f4f6f8' },
    },
    typography: {
        fontFamily: '"Inter", "Roboto", "Helvetica", "Arial", sans-serif',
    },
    components: {
        MuiButton: {
            styleOverrides: {
                root: { textTransform: 'none', borderRadius: 6 },
            },
        },
        MuiCard: {
            styleOverrides: {
                root: { borderRadius: 8, boxShadow: '0 1px 4px rgba(0,0,0,0.08)' },
            },
        },
    },
});

createInertiaApp({
    title: (title) => `${title} — Mini CRM`,
    resolve: (name) => {
        const pages = import.meta.glob('./pages/**/*.tsx', { eager: true });
        return pages[`./pages/${name}.tsx`] as { default: React.ComponentType };
    },
    setup({ el, App, props }) {
        createRoot(el).render(
            <ThemeProvider theme={theme}>
                <CssBaseline />
                <App {...props} />
            </ThemeProvider>
        );
    },
    progress: {
        color: '#1976d2',
    },
});
