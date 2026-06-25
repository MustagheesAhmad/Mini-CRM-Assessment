import { Chip } from '@mui/material';
import { LeadStatus } from '@/types';

const config: Record<LeadStatus, { label: string; color: 'default' | 'info' | 'success' }> = {
    new: { label: 'New', color: 'default' },
    contacted: { label: 'Contacted', color: 'info' },
    converted: { label: 'Converted', color: 'success' },
};

interface Props {
    status: LeadStatus;
}

export default function StatusChip({ status }: Props) {
    const { label, color } = config[status];
    return <Chip label={label} color={color} size="small" />;
}
