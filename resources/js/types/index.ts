export interface User {
    id: number;
    name: string;
    email: string;
    role: 'admin' | 'user';
}

export interface Lead {
    id: number;
    name: string;
    email: string;
    phone: string;
    status: LeadStatus;
    status_label: string;
    assigned_to: User | null;
    created_by: User;
    notes_count?: number;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

export type LeadStatus = 'new' | 'contacted' | 'converted';

export interface LeadNote {
    id: number;
    note: string;
    author: User;
    created_at: string;
}

export interface DashboardStats {
    total: number;
    new: number;
    contacted: number;
    converted: number;
}

export interface Pagination {
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
}

export interface PageProps {
    auth: {
        user: User | null;
    };
    flash: {
        success: string | null;
        error: string | null;
    };
    [key: string]: unknown;
}
