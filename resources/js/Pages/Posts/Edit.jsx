/**
 * This file contains the Edit component for managing posts
 * It handles editing existing posts in the system
 */

// Import React library for building UI components
import React from 'react';

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

export default function Edit({ auth }) {
    // Destruct permissions from usepage props
    const { posts } = usePage().props;

    // Define state with helper inertia
    const { data, setData, post, errors } = useForm({
        title: posts.title,
        post: posts.post,
        _method: 'put'
    });

    // Define method handleUpdateData
    const handleUpdateData = async (e) => {
        e.preventDefault();

        post(route('posts.update', posts.id), {
            onSuccess: () => {
                Swal.fire({
                    title: 'Success!',
                    text: 'Data updated successfully!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Post</h2>}
        >
            <Head title={'Edit Posts'} />
            <Container>
                <Card title={'Edit post'}>
                    <form onSubmit={handleUpdateData}>
                        <div className='mb-4'>
                            <Input label={'Title'} type={'text'} value={data.title} onChange={e => setData('title', e.target.value)} errors={errors.title} placeholder="Input post title.." />
                            <Input label={'Post'} type={'text'} value={data.post} onChange={e => setData('post', e.target.value)} errors={errors.post} placeholder="Input post.." />
                        </div>
                        <div className='flex items-center gap-2'>
                            <Button type={'submit'} />
                            <Button type={'cancel'} url={route('posts.index')} />
                        </div>
                    </form>
                </Card>
            </Container>
        </AuthenticatedLayout>
    );
}
