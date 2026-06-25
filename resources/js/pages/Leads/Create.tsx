import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Card, CardContent } from '@mui/material';
import AppLayout from '@/components/Layout/AppLayout';
import PageHeader from '@/components/shared/PageHeader';
import LeadForm, { LeadFormFields } from '@/components/leads/LeadForm';
import { PageProps, User } from '@/types';

interface Props extends PageProps {
    users: Pick<User, 'id' | 'name'>[];
    statuses: string[];
}

export default function CreateLead() {
    const { users, statuses } = usePage<Props>().props;
    const { setData, post, processing, errors } = useForm<LeadFormFields>({
        name: '',
        email: '',
        phone: '',
        status: 'new',
        assigned_to: null,
    });

    function handleSubmit(values: LeadFormFields) {
        setData(values);
        post('/leads');
    }

    return (
        <AppLayout>
            <Head title="New Lead" />
            <PageHeader title="New Lead" subtitle="Add a new lead to the CRM" />
            <Card sx={{ maxWidth: 600 }}>
                <CardContent sx={{ p: 3 }}>
                    <LeadForm
                        users={users}
                        statuses={statuses}
                        serverErrors={errors}
                        processing={processing}
                        onSubmit={handleSubmit}
                        submitLabel="Create Lead"
                        onCancel={() => router.visit('/leads')}
                    />
                </CardContent>
            </Card>
        </AppLayout>
    );
}
