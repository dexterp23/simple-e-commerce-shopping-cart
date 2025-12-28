import React, { useEffect } from 'react';
import { Head, usePage  } from '@inertiajs/react';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import NavLink from '@/Components/NavLink';
import toast, { Toaster } from 'react-hot-toast';

export default function Cart({ flash, products, filters  }) {
    const handlePageChange = (page) => {
        Inertia.get('/products', { page }, { preserveState: true, replace: true });
    };

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

            <Toaster position="top-right" reverseOrder={false} />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                     <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                         <div className="p-6 text-gray-900">

                             <table className="border-collapse border border-gray-300 w-full">
                                 <thead>
                                 <tr>
                                     <th className="border border-gray-300 px-4 py-2">Name</th>
                                     <th className="border border-gray-300 px-4 py-2">Price</th>
                                     <th className="border border-gray-300 px-4 py-2">Stock</th>
                                     <th className="border border-gray-300 px-4 py-2"></th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 {products.data.map((product) => (
                                     <tr key={product.id}>
                                         <td className="border border-gray-300 px-4 py-2">{product.name}</td>
                                         <td className="border border-gray-300 px-4 py-2">${product.price}</td>
                                         <td className="border border-gray-300 px-4 py-2">
                                             {product.stock_quantity == 0 ? (
                                                 <span className="text-red-500 font-bold">Out of stock</span>
                                             ) : (
                                                 product.stock_quantity
                                             )}
                                         </td>
                                         <td className="border border-gray-300 px-4 py-2">
                                             {product.stock_quantity > 0 && (
                                                 <NavLink
                                                     method="post"
                                                     href={route('cart.add')}
                                                     data={{ product_id: product.id }}
                                                     as="button"
                                                 >
                                                     Add to Cart
                                                 </NavLink>
                                             )}
                                         </td>
                                     </tr>
                                 ))}
                                 </tbody>
                             </table>

                             <div className="mt-4 flex justify-center items-center gap-2">
                                 {products.prev_page_url && (
                                     <button
                                         onClick={() => handlePageChange(products.current_page - 1)}
                                         className="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
                                     >
                                         Previous
                                     </button>
                                 )}

                                 <span>
                                    Page {products.current_page} of {products.last_page}
                                </span>

                                 {products.next_page_url && (
                                     <button
                                         onClick={() => handlePageChange(products.current_page + 1)}
                                         className="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
                                     >
                                         Next
                                     </button>
                                 )}
                             </div>

                         </div>
                     </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
