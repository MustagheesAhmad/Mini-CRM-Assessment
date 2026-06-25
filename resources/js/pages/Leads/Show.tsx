import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import {
    Avatar,
    Box,
    Button,
    Card,
    CardContent,
    CardHeader,
    Chip,
    CircularProgress,
    Divider,
    FormControl,
    Grid,
    InputLabel,
    MenuItem,
    Select,
    TextField,
    Typography,
} from '@mui/material';
import EditIcon from '@mui/icons-material/Edit';
import PersonIcon from '@mui/icons-material/Person';
import NoteAltIcon from '@mui/icons-material/NoteAlt';
import AppLayout from '@/components/Layout/AppLayout';
import PageHeader from '@/components/shared/PageHeader';
import StatusChip from '@/components/leads/StatusChip';
import { Lead, LeadNote, PageProps } from '@/types';
import { useState } from 'react';

interface LeadWithNotes extends Lead {
    notes: LeadNote[];
}

interface Props extends PageProps {
    lead: LeadWithNotes;
    statuses: string[];
}

function NotesTimeline({ notes }: { notes: LeadNote[] }) {
    if (notes.length === 0) {
        return (
            <Typography variant="body2" color="text.secondary" sx={{ py: 2, textAlign: 'center' }}>
                No notes yet.
            </Typography>
        );
    }

    return (
        <Box sx={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
            {notes.map((note) => (
                <Box key={note.id} sx={{ display: 'flex', gap: 1.5 }}>
                    <Avatar sx={{ width: 32, height: 32, fontSize: 13, bgcolor: 'primary.light', mt: 0.25 }}>
                        {note.author.name.charAt(0).toUpperCase()}
                    </Avatar>
                    <Box sx={{ flex: 1 }}>
                        <Box sx={{ display: 'flex', alignItems: 'baseline', gap: 1 }}>
                            <Typography variant="body2" sx={{ fontWeight: 600 }}>
                                {note.author.name}
                            </Typography>
                            <Typography variant="caption" color="text.secondary">
                                {new Date(note.created_at).toLocaleString()}
                            </Typography>
                        </Box>
                        <Typography
                            variant="body2"
                            sx={{
                                mt: 0.5,
                                p: 1.5,
                                backgroundColor: '#f4f6f8',
                                borderRadius: 1.5,
                                lineHeight: 1.6,
                            }}
                        >
                            {note.note}
                        </Typography>
                    </Box>
                </Box>
            ))}
        </Box>
    );
}

function AddNoteForm({ leadId, canAddNote }: { leadId: number; canAddNote: boolean }) {
    const { data, setData, post, processing, errors, reset } = useForm({ note: '' });

    if (!canAddNote) return null;

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        post(`/leads/${leadId}/notes`, {
            onSuccess: () => reset(),
        });
    }

    return (
        <Box component="form" onSubmit={handleSubmit} sx={{ mt: 2 }}>
            <Divider sx={{ mb: 2 }} />
            <TextField
                label="Add a note"
                multiline
                rows={3}
                fullWidth
                size="small"
                value={data.note}
                onChange={(e) => setData('note', e.target.value)}
                error={!!errors.note}
                helperText={errors.note}
                placeholder="What happened with this lead?"
            />
            <Box sx={{ mt: 1.5 }}>
                <Button
                    type="submit"
                    variant="contained"
                    size="small"
                    disabled={processing || !data.note.trim()}
                    startIcon={processing ? <CircularProgress size={14} color="inherit" /> : <NoteAltIcon />}
                >
                    Add Note
                </Button>
            </Box>
        </Box>
    );
}

function StatusUpdater({ lead, statuses }: { lead: Lead; statuses: string[] }) {
    const [status, setStatus] = useState<string>(lead.status);

    function handleUpdate() {
        router.patch(`/leads/${lead.id}/status`, { status });
    }

    const changed = status !== lead.status;

    return (
        <Box sx={{ display: 'flex', gap: 1.5, alignItems: 'flex-end' }}>
            <FormControl size="small" sx={{ minWidth: 160 }}>
                <InputLabel>Status</InputLabel>
                <Select
                    label="Status"
                    value={status}
                    onChange={(e) => setStatus(e.target.value)}
                >
                    {statuses.map((s) => (
                        <MenuItem key={s} value={s} sx={{ textTransform: 'capitalize' }}>
                            {s.charAt(0).toUpperCase() + s.slice(1)}
                        </MenuItem>
                    ))}
                </Select>
            </FormControl>
            {changed && (
                <Button variant="contained" size="small" onClick={handleUpdate}>
                    Update
                </Button>
            )}
        </Box>
    );
}

export default function ShowLead() {
    const { lead, statuses, auth } = usePage<Props>().props;

    const isAdmin = auth.user?.role === 'admin';
    const isAssigned = lead.assigned_to?.id === auth.user?.id;
    const canEdit = isAdmin || isAssigned;
    const canAddNote = isAdmin || isAssigned;
    const canUpdateStatus = isAdmin || isAssigned;

    const notes: LeadNote[] = (lead as LeadWithNotes).notes ?? [];

    return (
        <AppLayout>
            <Head title={lead.name} />

            <PageHeader
                title={lead.name}
                subtitle={lead.email}
                actions={
                    canEdit ? (
                        <Button
                            variant="outlined"
                            startIcon={<EditIcon />}
                            {...{ component: Link, href: `/leads/${lead.id}/edit` } as object}
                        >
                            Edit
                        </Button>
                    ) : undefined
                }
            />

            <Grid container spacing={3}>
                {/* Lead Info */}
                <Grid size={{ xs: 12, md: 5 }}>
                    <Card>
                        <CardHeader
                            title="Lead Information"
                            slotProps={{ title: { variant: 'subtitle1' } }} sx={{ '& .MuiCardHeader-title': { fontWeight: 600 } }}
                        />
                        <CardContent sx={{ pt: 0 }}>
                            <Box sx={{ display: 'flex', flexDirection: 'column', gap: 1.5 }}>
                                <InfoRow label="Phone" value={lead.phone} />
                                <InfoRow label="Email" value={lead.email} />
                                <Box>
                                    <Typography variant="caption" color="text.secondary" sx={{ display: 'block', mb: 0.5 }}>
                                        Status
                                    </Typography>
                                    <StatusChip status={lead.status} />
                                </Box>
                                <Box>
                                    <Typography variant="caption" color="text.secondary" sx={{ display: 'block', mb: 0.5 }}>
                                        Assigned To
                                    </Typography>
                                    {lead.assigned_to ? (
                                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                            <PersonIcon fontSize="small" color="action" />
                                            <Typography variant="body2">{lead.assigned_to.name}</Typography>
                                        </Box>
                                    ) : (
                                        <Chip label="Unassigned" size="small" variant="outlined" />
                                    )}
                                </Box>
                                <InfoRow
                                    label="Created"
                                    value={new Date(lead.created_at).toLocaleDateString()}
                                />
                            </Box>

                            {canUpdateStatus && (
                                <>
                                    <Divider sx={{ my: 2 }} />
                                    <Typography variant="body2" sx={{ fontWeight: 600, mb: 1.5 }}>
                                        Update Status
                                    </Typography>
                                    <StatusUpdater lead={lead} statuses={statuses} />
                                </>
                            )}
                        </CardContent>
                    </Card>
                </Grid>

                {/* Notes */}
                <Grid size={{ xs: 12, md: 7 }}>
                    <Card>
                        <CardHeader
                            title={`Notes (${notes.length})`}
                            slotProps={{ title: { variant: 'subtitle1' } }} sx={{ '& .MuiCardHeader-title': { fontWeight: 600 } }}
                        />
                        <CardContent sx={{ pt: 0 }}>
                            <NotesTimeline notes={notes} />
                            <AddNoteForm leadId={lead.id} canAddNote={canAddNote} />
                        </CardContent>
                    </Card>
                </Grid>
            </Grid>

        </AppLayout>
    );
}

function InfoRow({ label, value }: { label: string; value: string }) {
    return (
        <Box>
            <Typography variant="caption" color="text.secondary" sx={{ display: 'block' }}>
                {label}
            </Typography>
            <Typography variant="body2">{value}</Typography>
        </Box>
    );
}
