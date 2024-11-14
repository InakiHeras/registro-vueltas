import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="flex min-h-screen flex-col items-center bg-teal-100 pt-12 sm:justify-center sm:pt-0">
            <div className="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
                <img src="/assets/logo.png" alt="Logo" className="mx-auto mb-4 w-20" />
                <h2 className="text-center text-2xl font-bold mb-4">Iniciar Sesión</h2>
                {children}
            </div>
        </div>
    );
}
