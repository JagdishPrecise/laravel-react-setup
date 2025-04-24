import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

import { columns } from "./table-list/columns"
import { DataTable } from "./table-list/data-table"
import data from "./table-list/data.json"

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Website',
        href: '/website',
    },
];

export default function Website() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Website" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <DataTable columns={columns} data={data} />
            </div>
        </AppLayout>
    );
}
