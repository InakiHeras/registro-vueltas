import Modal from "@/Components/Modal";
import PrimaryButton from "@/Components/PrimaryButton";
import TableData from "@/Components/TableData";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { useState } from "react";
import AddPermission from "./AddPermission";

export default function Permissions({ auth, admin, permissions }) {
    
    const [currentPage, setCurrentPage] = useState(permissions.allPermissions.current_page);
    const [loading, setLoading] = useState(false);
    const [openAddPermission, setAddPermission] = useState(false);

    const columns = [
        {name: "ID", campo: "id"},
        {name: "Code", campo: "name"},
        {name: "Origen", campo: "guard_name"},
        {name: "Creado el", campo: "created_at"}
    ];

    const openAddModal = () => {
        setAddPermission(true);
    }
    const closeAddModal = () => {
        setAddPermission(false);
    }
    
    return (
        <AuthenticatedLayout
        user = {auth.user}
        admin = {admin}
        header = {
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                Permisos
            </h2>
        }>

            <Head title="Permisos" />

            <Modal
                maxWidth='2xl'
                show={openAddPermission}
                closeable={true}
                onClose={closeAddModal}
            >
                <AddPermission permissions={permissions.permissionsNotInDB}/>
            </Modal>

            <div className="flex space-x-4 p-4 bg-gray-100 rounded-md">
                <PrimaryButton onClick={openAddModal}>
                    <span className="mdi mdi-plus-box"></span> Nuevo
                </PrimaryButton>
            </div>

            <TableData 
                totalRows={permissions.allPermissions.total}
                columns={columns}
                data={permissions.allPermissions.data}
                perPage={permissions.allPermissions.per_page}
                currentPage={currentPage}
                setCurrentPage={setCurrentPage}
                loading={loading}
                titleTable="Permisos del sistema"
                classIcon="mdi mdi-account-multiple"
            />

        </AuthenticatedLayout>
    )
}