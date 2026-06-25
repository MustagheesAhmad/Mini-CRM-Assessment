import { Box, Typography } from '@mui/material';
import { ReactNode } from 'react';

interface Props {
    title: string;
    subtitle?: string;
    actions?: ReactNode;
}

export default function PageHeader({ title, subtitle, actions }: Props) {
    return (
        <Box
            sx={{
                display: 'flex',
                alignItems: 'flex-start',
                justifyContent: 'space-between',
                mb: 3,
            }}
        >
            <Box>
                <Typography variant="h5" color="text.primary" sx={{ fontWeight: 600 }}>
                    {title}
                </Typography>
                {subtitle && (
                    <Typography variant="body2" color="text.secondary" sx={{ mt: 0.25 }}>
                        {subtitle}
                    </Typography>
                )}
            </Box>
            {actions && <Box>{actions}</Box>}
        </Box>
    );
}
