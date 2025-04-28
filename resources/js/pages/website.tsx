import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

// import Table from '@/components/Table'; // Import your Table component
import DataTable from 'react-data-table-component';
import React, { useState } from 'react';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Website',
        href: '/website',
    },
];

const columns = [
    {
      name: 'Name',
      selector: row => row.name,
      sortable: true,
    },
    {
      name: 'Email',
      selector: row => row.email,
      sortable: true,
    },
    {
      name: 'Status',
      selector: row => row.status,
      sortable: true,
    },
  ];

export default function Website({data}: any) {
    const [searchQuery, setSearchQuery] = useState('');

    // Filtered data based on search query
    const filteredData = data.filter((item) => {
      return (
        item.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
        item.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
        item.status.toLowerCase().includes(searchQuery.toLowerCase())
      );
    });

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Website" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div className="flex items-center py-4">
            <input
                type="text"
                className="px-4 py-2 border border-gray-300 rounded-md"
                placeholder="Search..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)} // Update search query
                />
            </div>
                <DataTable
                    columns={columns}
                    data={filteredData}
                    pagination
                    responsive
                />
            </div>
        </AppLayout>
    );
}
