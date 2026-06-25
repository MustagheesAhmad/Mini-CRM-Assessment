import { Head, usePage } from '@inertiajs/react';
import { Box, Card, CardContent, Grid, Typography } from '@mui/material';
import TrendingUpIcon from '@mui/icons-material/TrendingUp';
import FiberNewIcon from '@mui/icons-material/FiberNew';
import PhoneIcon from '@mui/icons-material/Phone';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import AppLayout from '@/components/Layout/AppLayout';
import PageHeader from '@/components/shared/PageHeader';
import { DashboardStats, PageProps } from '@/types';

interface Props extends PageProps {
    stats: DashboardStats;
}

interface StatCardProps {
    label: string;
    value: number;
    icon: React.ReactNode;
    color: string;
}

function StatCard({ label, value, icon, color }: StatCardProps) {
    return (
        <Card>
            <CardContent sx={{ display: 'flex', alignItems: 'center', gap: 2, py: 2.5 }}>
                <Box
                    sx={{
                        width: 48,
                        height: 48,
                        borderRadius: 2,
                        backgroundColor: color,
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        flexShrink: 0,
                    }}
                >
                    {icon}
                </Box>
                <Box>
                    <Typography variant="h4" sx={{ fontWeight: 700, lineHeight: 1.1 }}>
                        {value}
                    </Typography>
                    <Typography variant="body2" color="text.secondary" sx={{ mt: 0.25 }}>
                        {label}
                    </Typography>
                </Box>
            </CardContent>
        </Card>
    );
}

export default function Dashboard() {
    const { stats, auth } = usePage<Props>().props;

    const cards: StatCardProps[] = [
        {
            label: 'Total Leads',
            value: stats.total,
            icon: <TrendingUpIcon sx={{ color: 'white', fontSize: 22 }} />,
            color: '#1976d2',
        },
        {
            label: 'New',
            value: stats.new,
            icon: <FiberNewIcon sx={{ color: 'white', fontSize: 22 }} />,
            color: '#757575',
        },
        {
            label: 'Contacted',
            value: stats.contacted,
            icon: <PhoneIcon sx={{ color: 'white', fontSize: 22 }} />,
            color: '#0288d1',
        },
        {
            label: 'Converted',
            value: stats.converted,
            icon: <CheckCircleIcon sx={{ color: 'white', fontSize: 22 }} />,
            color: '#2e7d32',
        },
    ];

    return (
        <AppLayout>
            <Head title="Dashboard" />
            <PageHeader
                title="Dashboard"
                subtitle={`Welcome back, ${auth.user?.name}`}
            />
            <Grid container spacing={2.5}>
                {cards.map((card) => (
                    <Grid size={{ xs: 12, sm: 6, md: 3 }} key={card.label}>
                        <StatCard {...card} />
                    </Grid>
                ))}
            </Grid>
        </AppLayout>
    );
}
