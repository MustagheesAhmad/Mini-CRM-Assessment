import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Card, CardContent } from '@mui/material';
import AppLayout from '@/components/Layout/AppLayout';
import PageHeader from '@/components/shared/PageHeader';
import LeadForm, { LeadFormFields } from '@/components/leads/LeadForm';
import { Lead, PageProps, User } from '@/types';

interface Props extends PageProps {
    lead: Lead;
    users: Pick<User, 'id' | 'name'>[];
    statuses: string[];
}

export default function EditLead() {
    const { lead, users, statuses } = usePage<Props>().props;

    const { setData, put, processing, errors } = useForm<LeadFormFields>({
        name: lead.name,
        email: lead.email,
        phone: lead.phone,
        status: lead.status,
        assigned_to: lead.assigned_to?.id ?? null,
    });

    function handleSubmit(values: LeadFormFields) {
        setData(values);
        put(`/leads/${lead.id}`);
    }

    return (
        <AppLayout>
            <Head title={`Edit — ${lead.name}`} />
            <PageHeader
                title="Edit Lead"
                subtitle={`Editing ${lead.name}`}
            />
            <Card sx={{ maxWidth: 600 }}>
                <CardContent sx={{ p: 3 }}>
                    <LeadForm
                        defaultValues={{
                            name: lead.name,
                            email: lead.email,
                            phone: lead.phone,
                            status: lead.status,
                            assigned_to: lead.assigned_to?.id ?? null,
                        }}
                        users={users}
                        statuses={statuses}
                        serverErrors={errors}
                        processing={processing}
                        onSubmit={handleSubmit}
                        submitLabel="Save Changes"
                        onCancel={() => router.visit(`/leads/${lead.id}`)}
                    />
                </CardContent>
            </Card>
        </AppLayout>
    );
}
