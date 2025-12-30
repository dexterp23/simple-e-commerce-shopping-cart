import { useForm  } from '@inertiajs/react';

export default function AddToCartForm({ item }) {
    const { data, setData, post, processing, errors } = useForm({
        quantity: 1,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('cart.add', item.id), {
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
                Add to Cart
            </button>
        </form>
    );
}
