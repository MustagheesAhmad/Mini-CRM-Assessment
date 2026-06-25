import { usePage } from '@inertiajs/react';
import { Alert, Snackbar } from '@mui/material';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import ErrorIcon from '@mui/icons-material/Error';
import { useEffect, useState } from 'react';
import { PageProps } from '@/types';

export default function FlashToast() {
    const { flash } = usePage<PageProps>().props;
    const [open, setOpen] = useState(false);
    const [message, setMessage] = useState<string | null>(null);
    const [severity, setSeverity] = useState<'success' | 'error'>('success');

    useEffect(() => {
        if (flash.success) {
            setMessage(flash.success);
            setSeverity('success');
            setOpen(true);
        } else if (flash.error) {
            setMessage(flash.error);
            setSeverity('error');
            setOpen(true);
        }
    }, [flash.success, flash.error]);

    return (
        <Snackbar
            open={open}
            autoHideDuration={4000}
            onClose={() => setOpen(false)}
            anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
        >
            <Alert
                onClose={() => setOpen(false)}
                severity={severity}
                variant="filled"
                icon={severity === 'success' ? <CheckCircleIcon /> : <ErrorIcon />}
                sx={{ minWidth: 300, boxShadow: 3, borderRadius: 2 }}
            >
                {message}
            </Alert>
        </Snackbar>
    );
}
