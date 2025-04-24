"use client"

import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { columns } from "./columns"
import { DataTable } from "./data-table"
import data from "./data.json"

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
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-6">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                  <DataTable columns={columns} data={data} />
                </div>
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>
            </div>
        </AppLayout>
    );
}
