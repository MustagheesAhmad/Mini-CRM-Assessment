import { Head, Link, router, usePage } from '@inertiajs/react';
import {
    Box,
    Button,
    Chip,
    FormControl,
    IconButton,
    InputAdornment,
    InputLabel,
    MenuItem,
    Pagination,
    Paper,
    Select,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
    TextField,
    Tooltip,
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import VisibilityIcon from '@mui/icons-material/Visibility';
import DeleteIcon from '@mui/icons-material/Delete';
import SearchIcon from '@mui/icons-material/Search';
import ClearIcon from '@mui/icons-material/Clear';
import AppLayout from '@/components/Layout/AppLayout';
import PageHeader from '@/components/shared/PageHeader';
import StatusChip from '@/components/leads/StatusChip';
import { Lead, PageProps, Pagination as PaginationType, User } from '@/types';
import { useState, useCallback } from 'react';

interface Props extends PageProps {
    leads: { data: Lead[] };
    pagination: PaginationType;
    filters: { status?: string; search?: string };
    users: Pick<User, 'id' | 'name'>[];
}

const STATUS_OPTIONS: { value: string; label: string }[] = [
    { value: '', label: 'All Statuses' },
    { value: 'new', label: 'New' },
    { value: 'contacted', label: 'Contacted' },
    { value: 'converted', label: 'Converted' },
];

export default function LeadsIndex() {
    const { leads, pagination, filters, auth } = usePage<Props>().props;
    const [search, setSearch] = useState(filters.search ?? '');

    const applyFilter = useCallback(
        (params: Record<string, string>) => {
            router.get('/leads', { ...filters, ...params, page: '1' }, {
                preserveState: true,
                replace: true,
            });
        },
        [filters]
    );

    function handleSearchSubmit(e: React.FormEvent) {
        e.preventDefault();
        applyFilter({ search });
    }

    function handleDelete(lead: Lead) {
        if (!confirm(`Delete lead "${lead.name}"? This action cannot be undone.`)) return;
        router.delete(`/leads/${lead.id}`);
    }

    const isAdmin = auth.user?.role === 'admin';

    return (
        <AppLayout>
            <Head title="Leads" />

            <PageHeader
                title="Leads"
                subtitle={`${pagination.total} total leads`}
                actions={
                    isAdmin ? (
                        <Button
                            variant="contained"
                            startIcon={<AddIcon />}
                            {...{ component: Link, href: '/leads/create' } as object}
                        >
                            New Lead
                        </Button>
                    ) : undefined
                }
            />

            {/* Filters */}
            <Box sx={{ display: 'flex', gap: 2, mb: 2.5, flexWrap: 'wrap' }}>
                <Box component="form" onSubmit={handleSearchSubmit} sx={{ display: 'flex', gap: 1 }}>
                    <TextField
                        size="small"
                        placeholder="Search name, email, phone…"
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        sx={{ width: 280 }}
                        slotProps={{
                            input: {
                                startAdornment: (
                                    <InputAdornment position="start">
                                        <SearchIcon fontSize="small" />
                                    </InputAdornment>
                                ),
                                endAdornment: search ? (
                                    <InputAdornment position="end">
                                        <IconButton
                                            size="small"
                                            onClick={() => {
                                                setSearch('');
                                                applyFilter({ search: '' });
                                            }}
                                        >
                                            <ClearIcon fontSize="small" />
                                        </IconButton>
                                    </InputAdornment>
                                ) : null,
                            },
                        }}
                    />
                    <Button type="submit" variant="outlined" size="small">
                        Search
                    </Button>
                </Box>

                <FormControl size="small" sx={{ minWidth: 160 }}>
                    <InputLabel>Status</InputLabel>
                    <Select
                        label="Status"
                        value={filters.status ?? ''}
                        onChange={(e) => applyFilter({ status: e.target.value })}
                    >
                        {STATUS_OPTIONS.map((opt) => (
                            <MenuItem key={opt.value} value={opt.value}>
                                {opt.label}
                            </MenuItem>
                        ))}
                    </Select>
                </FormControl>
            </Box>

            {/* Table */}
            <TableContainer component={Paper} elevation={0} sx={{ border: '1px solid #e8eaed' }}>
                <Table size="small">
                    <TableHead>
                        <TableRow sx={{ backgroundColor: '#fafafa' }}>
                            <TableCell sx={{ fontWeight: 600 }}>Name</TableCell>
                            <TableCell sx={{ fontWeight: 600 }}>Email</TableCell>
                            <TableCell sx={{ fontWeight: 600 }}>Phone</TableCell>
                            <TableCell sx={{ fontWeight: 600 }}>Status</TableCell>
                            <TableCell sx={{ fontWeight: 600 }}>Assigned To</TableCell>
                            <TableCell sx={{ fontWeight: 600 }} align="right">Actions</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {leads.data.length === 0 ? (
                            <TableRow>
                                <TableCell colSpan={6} align="center" sx={{ py: 4, color: 'text.secondary' }}>
                                    No leads found.
                                </TableCell>
                            </TableRow>
                        ) : (
                            leads.data.map((lead) => (
                                <TableRow key={lead.id} hover>
                                    <TableCell sx={{ fontWeight: 500 }}>{lead.name}</TableCell>
                                    <TableCell sx={{ color: 'text.secondary' }}>{lead.email}</TableCell>
                                    <TableCell sx={{ color: 'text.secondary' }}>{lead.phone}</TableCell>
                                    <TableCell>
                                        <StatusChip status={lead.status} />
                                    </TableCell>
                                    <TableCell sx={{ color: 'text.secondary' }}>
                                        {lead.assigned_to?.name ?? (
                                            <Chip label="Unassigned" size="small" variant="outlined" />
                                        )}
                                    </TableCell>
                                    <TableCell align="right">
                                        <Tooltip title="View Details">
                                            <IconButton
                                                size="small"
                                                {...{ component: Link, href: `/leads/${lead.id}` } as object}
                                            >
                                                <VisibilityIcon fontSize="small" />
                                            </IconButton>
                                        </Tooltip>
                                        <Tooltip title="Edit">
                                            <IconButton
                                                size="small"
                                                {...{ component: Link, href: `/leads/${lead.id}/edit` } as object}
                                            >
                                                <EditIcon fontSize="small" />
                                            </IconButton>
                                        </Tooltip>
                                        {isAdmin && (
                                            <Tooltip title="Delete">
                                                <IconButton
                                                    size="small"
                                                    color="error"
                                                    onClick={() => handleDelete(lead)}
                                                >
                                                    <DeleteIcon fontSize="small" />
                                                </IconButton>
                                            </Tooltip>
                                        )}
                                    </TableCell>
                                </TableRow>
                            ))
                        )}
                    </TableBody>
                </Table>
            </TableContainer>

            {/* Pagination */}
            {pagination.last_page > 1 && (
                <Box sx={{ display: 'flex', justifyContent: 'center', mt: 3 }}>
                    <Pagination
                        count={pagination.last_page}
                        page={pagination.current_page}
                        onChange={(_, page) =>
                            router.get('/leads', { ...filters, page: String(page) }, {
                                preserveState: true,
                            })
                        }
                        color="primary"
                        shape="rounded"
                    />
                </Box>
            )}

        </AppLayout>
    );
}
