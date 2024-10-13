import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import Modal from "@/Components/Modal";
import PrimaryButton from "@/Components/PrimaryButton";
import TableData from "@/Components/TableData";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Transition } from "@headlessui/react";
import { Head, useForm } from "@inertiajs/react";
import { useState } from "react";

export default function Roles({ auth, admin, roles }){
    
    const [currentPage, setCurrentPage] = useState(roles.current_page);
    const [loading, setLoading] = useState(false);
    const [openModalAdd, setOpenModalAdd] = useState(false);
    const [openModalEdit, setOpenModalEdit] = useState(false);
    const [rolEdit, setRolEdit] = useState({});
    
    const columns = [
        {name: "Id", campo: "id"},
        {name: "Code", campo: "name"},
        {name: "Origen", campo: "guard_name"},
        {name: "Creado el", campo: "created_at"}
    ];

    const renderActions = (item) => (
        <>
            <button className="button small green" type="button" onClick={() => hanldeOpenModalEdit(item)}>
                <span className="icon"><i className="mdi mdi-eye"></i></span>
            </button>
        </>
    );

    const hanldeOpenModalAdd = () => {
        setOpenModalAdd(true);
    }
    const hanldeCloseModalAdd = () => {
        setOpenModalAdd(false);
    }

    const hanldeOpenModalEdit = (item) => {
        setRolEdit(item);
        setOpenModalEdit(true);
    }
    const hanldeCloseModalEdit = () => {
        setOpenModalEdit(false);
    }

    const { data, setData, post, errors, processing, recentlySuccessful } = useForm(
        {
            rolename: '',
            guard_name: 'web'
        }
    );

    const addRolPost = (e) => {
        e.preventDefault();
        post(route('store.role'), {
            onSuccess: () => {
                data.rolename = ''
            },
            onFinish: () => { }
        });
    }

    const AddPerfilRolInterno = (
        <form className='p-4' onSubmit={addRolPost}>
            <div>
                <h1>Nuevo Rol de sistema</h1>
            </div>

            <div className='mt-2'>
                <InputLabel value='Nombre del rol' />
                <TextInput
                    id="rolename"
                    type="text"
                    name="rolename"
                    className="mt-1 block w-full"
                    isFocused={true}
                    onChange={(e) => setData('rolename', e.target.value)}
                    value={data.rolename}
                />
                <InputError message={errors.rolename} />
            </div>

            <div className='flex items-center justify-end mt-4 gap-4'>
                <PrimaryButton className='ms-4' disabled={processing}>
                    Guardar Rol
                </PrimaryButton>
                <Transition
                    show={recentlySuccessful}
                    enter="transition ease-in-out"
                    enterFrom="opacity-0"
                    leave="transition ease-in-out"
                    leaveTo="opacity-0"
                >
                    <p className='text-sm text-gray-600'> Rol guardado.</p>
                </Transition>
            </div>
        </form>
    )
    
    return (
        <AuthenticatedLayout
        user = {auth.user}
        admin = {admin}
        header = {
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        }>

            <Head title="Roles" />

            <Modal
                show={openModalAdd}
                onClose={hanldeCloseModalAdd}
                maxWidth='lg'
                closeable
            >
                {AddPerfilRolInterno}
            </Modal>

            <div className="flex space-x-4 p-4 bg-gray-100 rounded-md">
                <PrimaryButton onClick={hanldeOpenModalAdd}>
                    <span className="mdi mdi-plus-box"></span> Nuevo
                </PrimaryButton>
            </div>

            <TableData 
                totalRows={roles.total}
                columns={columns}
                data={roles.data}
                perPage={roles.per_page}
                currentPage={currentPage}
                setCurrentPage={setCurrentPage}
                loading={loading}
                titleTable="Roles del sistema"
                classIcon="mdi mdi-account-group-outline"
            />
        </AuthenticatedLayout>
    )
}