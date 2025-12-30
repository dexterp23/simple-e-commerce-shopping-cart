import { useForm  } from '@inertiajs/react';

export default function UpdateQuantityForm({ item }) {
    const { data, setData, patch, processing, errors } = useForm({
        quantity: item.quantity,
    });

    const submit = (e) => {
        e.preventDefault();

        patch(route('cart.update', item.product.id), {
            preserveScroll: true,
        });
    };

    return (
        <form onSubmit={submit} className="flex gap-2">
            <input
                type="number"
                min="1"
                value={data.quantity}
                onChange={e => setData('quantity', e.target.value)}
                className="border px-2 w-16"
            />

            <button
                type="submit"
                disabled={processing}
                className="bg-blue-500 text-white px-3"
            >
                Update
            </button>
        </form>
    );
}
