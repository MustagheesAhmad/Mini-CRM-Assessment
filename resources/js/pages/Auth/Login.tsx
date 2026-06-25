import { useForm } from '@inertiajs/react';
import { zodResolver } from '@hookform/resolvers/zod';
import { useForm as useHookForm } from 'react-hook-form';
import { z } from 'zod';
import {
    Alert,
    Box,
    Button,
    CircularProgress,
    Paper,
    TextField,
    Typography,
} from '@mui/material';
import LockOutlinedIcon from '@mui/icons-material/LockOutlined';
import { Head } from '@inertiajs/react';

const loginSchema = z.object({
    email: z.string().min(1, 'Email is required').email('Enter a valid email address'),
    password: z.string().min(1, 'Password is required'),
});

type LoginFields = z.infer<typeof loginSchema>;

export default function Login() {
    const { setData, post, processing, errors } = useForm<LoginFields>({
        email: '',
        password: '',
    });

    const {
        register,
        handleSubmit,
        formState: { errors: clientErrors },
    } = useHookForm<LoginFields>({
        resolver: zodResolver(loginSchema),
        defaultValues: { email: '', password: '' },
    });

    function onSubmit(values: LoginFields) {
        setData(values);
        post('/login');
    }

    return (
        <>
            <Head title="Login" />
            <Box
                sx={{
                    minHeight: '100vh',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    backgroundColor: '#f4f6f8',
                }}
            >
                <Paper
                    elevation={0}
                    sx={{
                        p: 4,
                        width: '100%',
                        maxWidth: 400,
                        border: '1px solid #e8eaed',
                        borderRadius: 2,
                    }}
                >
                    <Box sx={{ textAlign: 'center', mb: 3 }}>
                        <Box
                            sx={{
                                width: 48,
                                height: 48,
                                borderRadius: '50%',
                                backgroundColor: 'primary.main',
                                display: 'inline-flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                mb: 1.5,
                            }}
                        >
                            <LockOutlinedIcon sx={{ color: 'white', fontSize: 24 }} />
                        </Box>
                        <Typography variant="h5" sx={{ fontWeight: 600 }}>
                            Sign in
                        </Typography>
                        <Typography variant="body2" color="text.secondary" sx={{ mt: 0.5 }}>
                            Mini CRM — Internal Portal
                        </Typography>
                    </Box>

                    {errors.email && (
                        <Alert severity="error" sx={{ mb: 2 }}>
                            {errors.email}
                        </Alert>
                    )}

                    <Box
                        component="form"
                        onSubmit={handleSubmit(onSubmit)}
                        noValidate
                        sx={{ display: 'flex', flexDirection: 'column', gap: 2 }}
                    >
                        <TextField
                            label="Email address"
                            type="email"
                            autoComplete="email"
                            autoFocus
                            fullWidth
                            size="small"
                            {...register('email')}
                            error={!!clientErrors.email}
                            helperText={clientErrors.email?.message}
                        />

                        <TextField
                            label="Password"
                            type="password"
                            autoComplete="current-password"
                            fullWidth
                            size="small"
                            {...register('password')}
                            error={!!clientErrors.password}
                            helperText={clientErrors.password?.message}
                        />

                        <Button
                            type="submit"
                            variant="contained"
                            fullWidth
                            disabled={processing}
                            sx={{ py: 1.25, mt: 0.5 }}
                        >
                            {processing ? (
                                <CircularProgress size={20} color="inherit" />
                            ) : (
                                'Sign in'
                            )}
                        </Button>
                    </Box>
                </Paper>
            </Box>
        </>
    );
}
