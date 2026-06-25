import { Box, Toolbar } from '@mui/material';
import Sidebar from './Sidebar';
import Topbar from './Topbar';
import FlashToast from '@/components/shared/FlashToast';
import { ReactNode } from 'react';

interface Props {
    children: ReactNode;
}

export default function AppLayout({ children }: Props) {
    return (
        <Box sx={{ display: 'flex', minHeight: '100vh', backgroundColor: '#f4f6f8' }}>
            <Sidebar />
            <Topbar />
            <Box
                component="main"
                sx={{ flexGrow: 1, p: 3, minWidth: 0 }}
            >
                <Toolbar />
                {children}
            </Box>
            <FlashToast />
        </Box>
    );
}
