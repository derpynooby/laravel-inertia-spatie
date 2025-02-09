/**
 * This file contains the Index component for managing permissions
 * It displays a list of all permissions in the system with options to create, edit and delete
 */

// Import React library for building UI components
import React from 'react'

// Import layout component for authenticated pages
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

// Import reusable container component
import Container from '@/Components/Container';

// Import reusable table components
import Table from '@/Components/Table';

// Import reusable button component
import Button from '@/Components/Button';

// Import reusable pagination component
import Pagination from '@/Components/Pagination';

// Import Inertia utilities for page management
import { Head, usePage } from '@inertiajs/react';

// Import reusable search component
import Search from '@/Components/Search';

// Import utility for checking user permissions
import hasAnyPermission from '@/Utils/Permissions';
export default function Index({auth}) {

    // destruct permissions props
    const { permissions,filters } = usePage().props;

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-600 dark:text-gray-400 leading-tight">Permissions</h2>}
        >
            <Head title={'Permissions'}/>
            <Container>
                <div className='mb-4 flex items-center justify-between gap-4'>
                    {hasAnyPermission(['permissions create']) &&
                        <Button type={'add'} url={route('permissions.create')}/>
                    }
                    <div className='w-full md:w-4/6'>
                        <Search url={route('permissions.index')} placeholder={'Search permissions data by name...'} filter={filters}/>
                    </div>
                </div>
                <Table.Card title={'Permissions'}>
                    <Table>
                        <Table.Thead>
                            <tr>
                                <Table.Th>#</Table.Th>
                                <Table.Th>Permissions Name</Table.Th>
                                <Table.Th>Action</Table.Th>
                            </tr>
                        </Table.Thead>
                        <Table.Tbody>
                            {permissions.data.map((permission, i) => (
                                <tr key={i}>
                                    <Table.Td>{++i + (permissions.current_page-1) * permissions.per_page}</Table.Td>
                                    <Table.Td>{permission.name}</Table.Td>
                                    <Table.Td>
                                        <div className='flex items-center gap-2'>
                                            {hasAnyPermission(['permissions edit']) &&
                                                <Button type={'edit'} url={route('permissions.edit', permission.id)}/>
                                            }
                                            {hasAnyPermission(['permissions delete']) &&
                                                <Button type={'delete'} url={route('permissions.destroy', permission.id)}/>
                                            }
                                        </div>
                                    </Table.Td>
                                </tr>
                            ))}
                        </Table.Tbody>
                    </Table>
                </Table.Card>
                <div className='flex items-center justify-center'>
                    {permissions.last_page !== 1 && (<Pagination links={permissions.links}/>)}
                </div>
            </Container>
        </AuthenticatedLayout>
    )
}