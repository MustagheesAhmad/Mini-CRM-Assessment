import { router, usePage } from '@inertiajs/react';
import {
    AppBar,
    Box,
    Button,
    Chip,
    Toolbar,
    Typography,
} from '@mui/material';
import LogoutIcon from '@mui/icons-material/Logout';
import { PageProps } from '@/types';

export default function Topbar() {
    const { auth } = usePage<PageProps>().props;

    function handleLogout() {
        router.post('/logout');
    }

    return (
        <AppBar
            position="fixed"
            elevation={0}
            sx={{
                backgroundColor: '#ffffff',
                borderBottom: '1px solid #e8eaed',
                ml: '220px',
                width: 'calc(100% - 220px)',
            }}
        >
            <Toolbar sx={{ justifyContent: 'flex-end', gap: 1.5 }}>
                {auth.user && (
                    <>
                        <Typography variant="body2" color="text.secondary">
                            {auth.user.name}
                        </Typography>
                        {auth.user.role === 'admin' && (
                            <Chip label="Admin" size="small" color="primary" variant="outlined" />
                        )}
                        <Box sx={{ width: 1, borderLeft: '1px solid #e8eaed', height: 24 }} />
                        <Button
                            size="small"
                            variant="text"
                            color="inherit"
                            startIcon={<LogoutIcon fontSize="small" />}
                            onClick={handleLogout}
                            sx={{ color: 'text.secondary', fontSize: 13 }}
                        >
                            Logout
                        </Button>
                    </>
                )}
            </Toolbar>
        </AppBar>
    );
}
