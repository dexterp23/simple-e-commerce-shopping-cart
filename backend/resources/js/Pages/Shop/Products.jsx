import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";

export default function Products({ products, filters  }) {
    const [filter_name, setSearch] = useState(filters.filter_name || '');

    const handlePageChange = (page) => {
        Inertia.get('/products', { page }, { preserveState: true, replace: true });
    };

    const handleSearchSubmit = (e) => {
        e.preventDefault();
        Inertia.get('/products', { filter_name }, { preserveState: true, replace: true });
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Products
                </h2>
            }
        >
            <Head title="Products"/>

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                     <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                         <div className="p-6 text-gray-900">

                             <form onSubmit={handleSearchSubmit} className="mb-4 flex gap-2">
                                 <input
                                     type="text"
                                     value={filter_name}
                                     onChange={(e) => setSearch(e.target.value)}
                                     placeholder="Search by name..."
                                     className="border border-gray-300 px-3 py-1 rounded w-full"
                                 />
                                 <button
                                     type="submit"
                                     className="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600"
                                 >
                                     Search
                                 </button>
                             </form>

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
                                                 <form method="POST" action={route('cart.add')}>
                                                     <input type="hidden" name="_token"
                                                            value={document.querySelector('meta[name="csrf-token"]').content}/>
                                                     <input type="hidden" name="product_id" value={product.id}/>
                                                     <button type="submit"
                                                             className="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                                         Add to Cart
                                                     </button>
                                                 </form>
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
