import React, { useEffect } from 'react';
import { Head  } from '@inertiajs/react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import UpdateQuantityForm from "@/Components/UpdateQuantityForm.jsx";
import toast, { Toaster } from 'react-hot-toast';
import NavLink from "@/Components/NavLink.jsx";

export default function Cart({ flash, products, total, actions  }) {

    useEffect(() => {
        Object.entries(flash).forEach(([type, message]) => {
            if (!message) return;
            switch (type) {
                case 'success':
                    toast.success(message);
                    break;
                case 'error':
                    toast.error(message);
                    break;
                default:
                    toast(message);
            }
        });
    }, [flash]);

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Cart
                </h2>
            }
        >
            <Head title="Cart"/>

            <Toaster position="top-right" reverseOrder={false}/>

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">

                            <table className="border-collapse border border-gray-300 w-full">
                                <thead>
                                <tr>
                                    <th className="border border-gray-300 px-4 py-2">Name</th>
                                    <th className="border border-gray-300 px-4 py-2">Price</th>
                                    <th className="border border-gray-300 px-4 py-2">Quantity</th>
                                    <th className="border border-gray-300 px-4 py-2">Total</th>
                                    <th className="border border-gray-300 px-4 py-2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                {products.map((item) => (
                                    <tr key={item.id}>
                                        <td className="border border-gray-300 px-4 py-2">{item.product.name}</td>
                                        <td className="border border-gray-300 px-4 py-2">${item.product.price}</td>
                                        <td className="border border-gray-300 px-4 py-2">
                                            <UpdateQuantityForm item={item}/>
                                        </td>
                                        <td className="border border-gray-300 px-4 py-2">${item.total}</td>
                                        <td className="border border-gray-300 px-4 py-2">
                                            <NavLink
                                                method="delete"
                                                href={route('cart.remove', item.product_id)}
                                                as="button"
                                            >
                                                Remove
                                            </NavLink>
                                        </td>
                                    </tr>
                                ))}
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th className="border border-gray-300 px-4 py-2"></th>
                                    <th className="border border-gray-300 px-4 py-2"></th>
                                    <th className="border border-gray-300 px-4 py-2"></th>
                                    <th className="border border-gray-300 px-4 py-2">${total}</th>
                                    <th className="border border-gray-300 px-4 py-2"></th>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div className="py-0">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">

                            Actions

                            <div style={{maxHeight: '400px', overflowY: 'auto'}}>
                                <table className="border-collapse border border-gray-300 w-full">
                                    <thead>
                                    <tr>
                                        <th className="border border-gray-300 px-4 py-2">Name</th>
                                        <th className="border border-gray-300 px-4 py-2">Quantity</th>
                                        <th className="border border-gray-300 px-4 py-2">Action</th>
                                        <th className="border border-gray-300 px-4 py-2">Date and Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {actions.map((action) => (
                                        <tr key={action.id}>
                                            <td className="border border-gray-300 px-4 py-2">{action.product.name}</td>
                                            <td className="border border-gray-300 px-4 py-2">{action.quantity}</td>
                                            <td className="border border-gray-300 px-4 py-2">{action.action}</td>
                                            <td className="border border-gray-300 px-4 py-2">
                                                {new Date(action.created_at).toLocaleDateString('en-UK', {
                                                    year: 'numeric',
                                                    month: 'short',
                                                    day: 'numeric',
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                })}
                                            </td>
                                        </tr>
                                    ))}
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
