import { useForm as useHookForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import {
    Box,
    Button,
    CircularProgress,
    FormControl,
    FormHelperText,
    InputLabel,
    MenuItem,
    Select,
    TextField,
} from '@mui/material';
import { LeadStatus, User } from '@/types';

const leadSchema = z.object({
    name: z.string().min(1, 'Name is required').max(255),
    email: z.string().min(1, 'Email is required').email('Enter a valid email'),
    phone: z.string().min(1, 'Phone is required').max(30),
    status: z.enum(['new', 'contacted', 'converted']).optional(),
    assigned_to: z.number().nullable().optional(),
});

export type LeadFormFields = z.infer<typeof leadSchema>;

interface Props {
    defaultValues?: Partial<LeadFormFields>;
    users: Pick<User, 'id' | 'name'>[];
    statuses: string[];
    serverErrors?: Partial<Record<keyof LeadFormFields, string>>;
    processing: boolean;
    onSubmit: (data: LeadFormFields) => void;
    submitLabel: string;
    onCancel: () => void;
}

export default function LeadForm({
    defaultValues,
    users,
    statuses,
    serverErrors = {},
    processing,
    onSubmit,
    submitLabel,
    onCancel,
}: Props) {
    const {
        register,
        handleSubmit,
        setValue,
        watch,
        formState: { errors },
    } = useHookForm<LeadFormFields>({
        resolver: zodResolver(leadSchema),
        defaultValues: {
            name: '',
            email: '',
            phone: '',
            status: 'new',
            assigned_to: null,
            ...defaultValues,
        },
    });

    const currentStatus = watch('status');
    const currentAssignee = watch('assigned_to');

    const fieldError = (field: keyof LeadFormFields) =>
        errors[field]?.message ?? serverErrors[field];

    return (
        <Box
            component="form"
            onSubmit={handleSubmit(onSubmit)}
            noValidate
            sx={{ display: 'flex', flexDirection: 'column', gap: 2.5 }}
        >
            <TextField
                label="Full Name"
                fullWidth
                size="small"
                {...register('name')}
                error={!!fieldError('name')}
                helperText={fieldError('name')}
            />

            <TextField
                label="Email Address"
                type="email"
                fullWidth
                size="small"
                {...register('email')}
                error={!!fieldError('email')}
                helperText={fieldError('email')}
            />

            <TextField
                label="Phone Number"
                fullWidth
                size="small"
                {...register('phone')}
                error={!!fieldError('phone')}
                helperText={fieldError('phone')}
            />

            <FormControl fullWidth size="small" error={!!fieldError('status')}>
                <InputLabel>Status</InputLabel>
                <Select
                    label="Status"
                    value={currentStatus ?? 'new'}
                    onChange={(e) => setValue('status', e.target.value as LeadStatus)}
                >
                    {statuses.map((s) => (
                        <MenuItem key={s} value={s} sx={{ textTransform: 'capitalize' }}>
                            {s.charAt(0).toUpperCase() + s.slice(1)}
                        </MenuItem>
                    ))}
                </Select>
                {fieldError('status') && (
                    <FormHelperText>{fieldError('status')}</FormHelperText>
                )}
            </FormControl>

            {users.length > 0 && (
                <FormControl fullWidth size="small">
                    <InputLabel>Assign To</InputLabel>
                    <Select
                        label="Assign To"
                        value={currentAssignee ?? ''}
                        onChange={(e) =>
                            setValue(
                                'assigned_to',
                                (e.target.value as unknown as string) === '' ? null : Number(e.target.value)
                            )
                        }
                    >
                        <MenuItem value="">Unassigned</MenuItem>
                        {users.map((u) => (
                            <MenuItem key={u.id} value={u.id}>
                                {u.name}
                            </MenuItem>
                        ))}
                    </Select>
                </FormControl>
            )}

            <Box sx={{ display: 'flex', gap: 1.5, pt: 1 }}>
                <Button
                    type="submit"
                    variant="contained"
                    disabled={processing}
                    startIcon={processing ? <CircularProgress size={16} color="inherit" /> : null}
                >
                    {submitLabel}
                </Button>
                <Button variant="outlined" color="inherit" onClick={onCancel}>
                    Cancel
                </Button>
            </Box>
        </Box>
    );
}
