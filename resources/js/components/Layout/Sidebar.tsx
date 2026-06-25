import { Link, usePage } from '@inertiajs/react';
import {
    Box,
    Drawer,
    List,
    ListItemButton,
    ListItemIcon,
    ListItemText,
    Typography,
} from '@mui/material';
import DashboardIcon from '@mui/icons-material/Dashboard';
import PeopleIcon from '@mui/icons-material/People';
import { PageProps } from '@/types';

const DRAWER_WIDTH = 220;

const navItems = [
    { label: 'Dashboard', href: '/dashboard', icon: <DashboardIcon fontSize="small" /> },
    { label: 'Leads', href: '/leads', icon: <PeopleIcon fontSize="small" /> },
];

export default function Sidebar() {
    const { url } = usePage<PageProps>();

    return (
        <Drawer
            variant="permanent"
            sx={{
                width: DRAWER_WIDTH,
                flexShrink: 0,
                '& .MuiDrawer-paper': {
                    width: DRAWER_WIDTH,
                    boxSizing: 'border-box',
                    backgroundColor: '#1a2035',
                    color: '#ffffff',
                    borderRight: 'none',
                },
            }}
        >
            <Box sx={{ px: 2.5, py: 2.5 }}>
                <Typography
                    variant="subtitle1"
                    sx={{ fontWeight: 700, letterSpacing: 0.5, color: 'white' }}
                >
                    Mini CRM
                </Typography>
            </Box>

            <List dense sx={{ px: 1 }}>
                {navItems.map((item) => {
                    const active = url.startsWith(item.href);
                    return (
                        <ListItemButton
                            key={item.href}
                            {...{ component: Link, href: item.href } as object}
                            selected={active}
                            sx={{
                                borderRadius: 1.5,
                                mb: 0.5,
                                color: active ? '#ffffff' : 'rgba(255,255,255,0.65)',
                                '&.Mui-selected': {
                                    backgroundColor: 'rgba(255,255,255,0.12)',
                                    '&:hover': { backgroundColor: 'rgba(255,255,255,0.16)' },
                                },
                                '&:hover': { backgroundColor: 'rgba(255,255,255,0.08)' },
                            }}
                        >
                            <ListItemIcon sx={{ minWidth: 36, color: 'inherit' }}>
                                {item.icon}
                            </ListItemIcon>
                            <ListItemText
                                primary={item.label}
                                slotProps={{ primary: { sx: { fontSize: 14, fontWeight: active ? 600 : 400 } } }}
                            />
                        </ListItemButton>
                    );
                })}
            </List>
        </Drawer>
    );
}
