import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function Roles({ auth, admin }){
    return (
        <AuthenticatedLayout
            admin={admin}>
            
        </AuthenticatedLayout>
    )
}