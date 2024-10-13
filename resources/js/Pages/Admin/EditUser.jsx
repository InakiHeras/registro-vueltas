import { useState } from "react";
import { useForm } from "@inertiajs/react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import PrimaryButton from "@/Components/PrimaryButton";
import { Transition } from "@headlessui/react";
import InputError from "@/Components/InputError";
import SelectInput from "@/Components/SelectInput";
import UserRoles from "./UserRoles";
//import UserRoles from "./UserRoles";

export default function EditUser({ user }) {
    
    const status = [
        {
            value: 1,
            label: "Activo",
        },
        {
            value: 2,
            label: "Inactivo",
        },
    ];
    const [activeTab, setActiveTab] = useState(0);

    const { data, setData, put, errors, processing, recentlySuccessful } = 
        useForm({
            name: user.name,
            email: user.email,
            password: "",
            status: user.status,
            id: user.id,
        });
    const submit = (e) => {
        e.preventDefault();
        put(`/admin/users/${user.id}`, {
            onSuccess: () => {},
        });
    };

    const FormUser = (
        <form onSubmit={submit} className="p-4">
            <div className="grid grid-cols-2 gap-2 mt-2">
                <div>
                    <InputLabel value={"Nombre usuario"} />
                    <TextInput
                        value={data.name}
                        className={"w-full"}
                        onChange={(e) => setData("name", e.target.value)}
                        isFocused
                    />
                    <InputError message={errors.name}></InputError>
                </div>
                <div>
                    <InputLabel value={"Correo"} />
                    <TextInput
                        value={data.email}
                        className={"w-full"}
                        onChange={(e) => setData("email", e.target.value)}
                        isFocused
                    />
                    <InputError message={errors.email}></InputError>
                </div>
            </div>
            <div className="grid grid-cols-2 gap-2 mt-2">
                <div>
                    <InputLabel value={"Contraseña"} />
                    <TextInput
                        value={data.password}
                        className={"w-full"}
                        onChange={(e) => setData("password", e.target.value)}
                        isFocused
                    />
                    <InputError message={errors.password}></InputError>
                </div>
                <div>
                    <InputLabel value={"Cambiar estado"} />
                    <SelectInput
                        id="status"
                        type="text"
                        name="status"
                        className="mt-1 block w-full"
                        isFocused={true}
                        options={status}
                        onChange={(e) => setData("status", e.target.value)}
                    ></SelectInput>
                </div>
            </div>
            <div className="flex items-center justify-end mt-4">
                <PrimaryButton className="ms-4" disabled={processing}>
                    GUARDAR USUARIO
                </PrimaryButton>
                <Transition
                    show={recentlySuccessful}
                    enter="transition ease-in-out"
                    enterFrom="opacity-0"
                    leave="transition ease-in-out"
                    leaveTo="opacity-0"
                >
                    <p className="text-sm text-gray-600">Usuario guardado.</p>
                </Transition>
            </div>
        </form>
    );

    const tabs = [
        {
            title: "Editar Usuario",
            content: FormUser,
        },
        {
            title: "Roles de Usuario",
            content: <UserRoles user={user} />,
        },
    ];

    return (
        <div className="w-full">
            <div className="flex border-b border-gray-300">
                {tabs.map((tab, index) => (
                    <button
                        key={index}
                        onClick={() => setActiveTab(index)}
                        className={`p-4 ${
                            activeTab === index
                                ? "border-b-2 border-primary text-primary"
                                : ""
                        }`}
                    >
                        {tab.title}
                    </button>
                ))}
            </div>
            <div className="p-4">{tabs[activeTab].content}</div>
        </div>
    );
}