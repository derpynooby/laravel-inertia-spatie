/**
 * This file contains the Edit component for managing permissions
 * It handles editing existing permissions in the system
 */

// Import React library for building UI components
import React from 'react'

// Import layout component for authenticated pages
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

// Import reusable container component
import Container from '@/Components/Container';

// Import Inertia utilities for form handling and navigation
import { Head, useForm, usePage } from '@inertiajs/react';

// Import reusable form components
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import Card from '@/Components/Card';

// Import SweetAlert2 for showing notifications
import Swal from 'sweetalert2';
export default function Edit({auth}) {

    // destruct permissions from usepage props
    const { permission } = usePage().props;

    // define state with helper inertia
    const { data, setData, post, errors } = useForm({
        name : permission.name,
        _method: 'put'
    });

    // define method handleUpdateData
    const handleUpdateData = async (e) => {
        e.preventDefault();

        post(route('permissions.update', permission.id), {
            onSuccess: () => {
                Swal.fire({
                    title: 'Success!',
                    text: 'Data updated successfully!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        });
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Permission</h2>}
        >
            <Head title={'Edit Permissions'}/>
            <Container>
                <Card title={'Edit permission'}>
                    <form onSubmit={handleUpdateData}>
                        <div className='mb-4'>
                            <Input label={'Permission Name'} type={'text'} value={data.name} onChange={e => setData('name', e.target.value)} errors={errors.name} placeholder="Input permission name.."/>
                        </div>
                        <div className='flex items-center gap-2'>
                            <Button type={'submit'} />
                            <Button type={'cancel'} url={route('permissions.index')}/>
                        </div>
                    </form>
                </Card>
            </Container>
        </AuthenticatedLayout>
    )
}