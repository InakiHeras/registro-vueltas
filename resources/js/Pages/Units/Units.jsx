import Modal from "@/Components/Modal";
import TableData from "@/Components/TableData";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { useState } from "react";
import NewUnit from "./NewUnit";
import PrimaryButton from "@/Components/PrimaryButton";

export default function Units({ auth, admin, units }){

    const [currentPage, setCurrentPage] = useState(units.current_page); // Página actual
    const [loading, setLoading] = useState(false);
    const [openModal, setOpenModal] = useState(false);

    const columns = [
        {name: "ID", campo: "IdCode"},
        {name: "Unidad", campo: "Unidad"},
        {
            name: "Código QR", 
            campo: "CodeQ",
            render: (row) => (
                <img src={`/storage/${row.CodeQ}`} alt={`Código QR para unidad ${row.Unidad}`} className="w-16 h-16" />
        )},
        {name: "Creado el", campo: "CreatedAt"},
    ]

    const hanldeOpenModal = () => {
        setOpenModal(true);
    };
    
    const hanldeCloseModal = () => {
        setOpenModal(false);
    };

    return (
        <AuthenticatedLayout
        user = {auth.user}
        admin = {admin}
        header = {
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                Unidades
            </h2>
        }>

            <Head title="Unidades"/>

            <Modal
                maxWidth="xl"
                show={openModal}
                closeable={true}
                onClose={hanldeCloseModal}
            >
                <NewUnit></NewUnit>
            </Modal>
            <div className="flex space-x-4 p-4 bg-gray-100 rounded-md">
                <PrimaryButton onClick={hanldeOpenModal}>
                    <span className="mdi mdi-plus-box"></span> Nuevo
                </PrimaryButton>
            </div>

            <TableData 
                totalRows={units.total}
                columns={columns}
                data={units.data}
                perPage={units.per_page}
                currentPage={currentPage}
                setCurrentPage={setCurrentPage}
                loading={loading}
                titleTable="Lista de Unidades"
                classIcon="mdi mdi-bus"
            />
        </AuthenticatedLayout>
    )
}