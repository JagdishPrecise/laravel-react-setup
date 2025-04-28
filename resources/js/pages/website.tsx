import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

// import Table from '@/components/Table'; // Import your Table component
import DataTable from 'react-data-table-component';
import React, { useState, useEffect } from 'react';
import { Button } from '@/components/ui/button';



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
            <div className="flex items-center">

                <div className="flex flex-col gap-4">
                    <input
                        type="text"
                        className="px-4 py-2 border border-gray-300 rounded-md"
                        placeholder="Search..."
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)} // Update search query
                    />
                </div>
                <div className="flex flex-col gap-4">
                    <Button type="button" variant="outline" className="w-full"  onClick={() => window.location.href = '/website-add'}>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                        d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"
                        fill="currentColor"
                        />
                    </svg>
                    Login with Google
                    </Button>
                </div>
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
