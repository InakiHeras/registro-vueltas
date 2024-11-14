import Modal from "@/Components/Modal";
import TableData from "@/Components/TableData";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { useState } from "react";
import CreateUser from "./CreateUser";
import PrimaryButton from "@/Components/PrimaryButton";
import EditUser from "./EditUser";

export default function Users({ auth, admin, users }) {
    
    const [currentPage, setCurrentPage] = useState(users.current_page); // Página actual
    const [loading, setLoading] = useState(false);
    const [openModal, setOpenModal] = useState(false);
    const [openModalCreate, setOpenModalCreate] = useState(false);
    const [userEdit, setUserEdit] = useState({});

    const columns = [
        {name: "ID", campo: "id"},
        {name: "Nombre", campo: "name"},
        {name: "Correo electrónico", campo: "email"},
        {name: "Fecha de creación", campo: "created_at"}
    ];

    const renderActions = (user) => (
        <>
            <button
                className="button small green"
                type="button"
                onClick={() => hanldeOpenModal(user)}
            >
                <span className="icon">
                    <i className="mdi mdi-pencil"></i>
                </span>
            </button>
        </>
    );

    const hanldeOpenModal = (user) => {
        setOpenModal(true);
        setUserEdit(user);
    };
    //mostar el modal create
    const hanldeOpenModalCreate = () => {
        setOpenModalCreate(true);
    };

    const hanldeCloseModal = () => {
        setOpenModal(false);
    };
    //ocultar modal create
    const hanldeCloseModalCreate = () => {
        setOpenModalCreate(false);
    };

    return(
        <AuthenticatedLayout
        user = {auth.user}
        admin = {admin}
        header = {
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios
            </h2>
        }>

            <Head title="Usuarios"/>

            <Modal
                maxWidth="xl"
                show={openModalCreate}
                closeable={true}
                onClose={hanldeCloseModalCreate}
            >
                <CreateUser onClose={hanldeCloseModalCreate}></CreateUser>
            </Modal>
            <div className="flex space-x-4 p-4 bg-gray-100 rounded-md">
                <PrimaryButton onClick={hanldeOpenModalCreate}>
                    <span className="mdi mdi-plus-box"></span> Nuevo
                </PrimaryButton>
            </div>

            <Modal
                maxWidth="3xl"
                show={openModal}
                closeable={true}
                onClose={hanldeCloseModal}
            >
                <EditUser user={userEdit}></EditUser>
            </Modal>

            <TableData 
                totalRows={users.total}
                columns={columns}
                data={users.data}
                perPage={users.per_page}
                currentPage={currentPage}
                setCurrentPage={setCurrentPage}
                loading={loading}
                titleTable="Lista de Usuarios"
                classIcon="mdi mdi-account-multiple"
                renderActions={renderActions}
                links={users.links}
            />

        </AuthenticatedLayout>
    )
}