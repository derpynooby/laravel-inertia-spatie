/**
 * This file contains the Index component for managing posts
 * It displays a list of all posts in the system with options to create, edit and delete
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

// Import utility for checking user posts
import hasAnyPermission from '@/Utils/Permissions';
export default function Index({auth}) {

    // destruct permissions props
    const { posts ,filters } = usePage().props;

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-600 dark:text-gray-400 leading-tight">Posts</h2>}
        >
            <Head title={'Post'}/>
            <Container>
                <div className='mb-4 flex items-center justify-between gap-4'>
                    {hasAnyPermission(['posts create']) &&
                        <Button type={'add'} url={route('posts.create')}/>
                    }
                    <div className='w-full md:w-4/6'>
                        <Search url={route('posts.index')} placeholder={'Search posts data by name...'} filter={filters}/>
                    </div>
                </div>
                <Table.Card title={'Posts'}>
                    <Table>
                        <Table.Thead>
                            <tr>
                                <Table.Th>#</Table.Th>
                                <Table.Th>Title</Table.Th>
                                <Table.Th>Post</Table.Th>
                                <Table.Th>Action</Table.Th>
                            </tr>
                        </Table.Thead>
                        <Table.Tbody>
                            {posts.data.map((post, i) => (
                                <tr key={i}>
                                    <Table.Td>{++i + (posts.current_page-1) * posts.per_page}</Table.Td>
                                    <Table.Td>{post.title}</Table.Td>
                                    <Table.Td>{post.post}</Table.Td>
                                    <Table.Td>
                                        <div className='flex items-center gap-2'>
                                            {hasAnyPermission(['posts edit']) &&
                                                <Button type={'edit'} url={route('posts.edit', post.id)}/>
                                            }
                                            {hasAnyPermission(['posts delete']) &&
                                                <Button type={'delete'} url={route('posts.destroy', post.id)}/>
                                            }
                                        </div>
                                    </Table.Td>
                                </tr>
                            ))}
                        </Table.Tbody>
                    </Table>
                </Table.Card>
                <div className='flex items-center justify-center'>
                    {posts.last_page !== 1 && (<Pagination links={posts.links}/>)}
                </div>
            </Container>
        </AuthenticatedLayout>
    )
}