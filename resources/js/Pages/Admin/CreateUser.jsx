import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Transition } from "@headlessui/react";
import { useForm } from "@inertiajs/react";
import { Input } from "postcss";

export default function CreateUser({ onClose }){
    
    const { data, setData, post, errors, processing, recentlySuccessful } =
        useForm({
            name: "",
            email: "",
            password: "",
        });

    const submitData = (e) => {
        e.preventDefault();
        post("/admin/users", {
            onSuccess: () => {
                onClose();
            }
        });
    };

    return(
        <form className="p-4" onSubmit={submitData}>
            <div>
                <h1>Nuevo Usuario</h1>
            </div>
            <div className="mt-2">
                <InputLabel htmlFor="nombreUsuario" value="Nombre de usuario" />
                <TextInput
                    id="name"
                    name="name"
                    value={data.name}
                    className={"w-full , mt-2"}
                    onChange={(e) => setData("name", e.target.value)}
                    required
                    isFocused
                ></TextInput>
                <InputError message={errors.name}></InputError>
            </div>
            <div className="mt-2">
                <InputLabel htmlFor="correoUsuario" value="Correo electrónico" />
                <TextInput
                    id="email"
                    name="email"
                    value={data.email}
                    className={"w-full , mt-2"}
                    onChange={(e) => setData("email", e.target.value)}
                    required
                    isFocused
                ></TextInput>
                <InputError message={errors.email}></InputError>
            </div>
            <div className="mt-2">
                <InputLabel htmlFor="contraseñaUsuario" value="Contraseña" />
                <TextInput
                    id="password"
                    name="password"
                    value={data.password}
                    className={"w-full , mt-2"}
                    onChange={(e) => setData("password", e.target.value)}
                    required
                    isFocused
                ></TextInput>
                <InputError message={errors.password}></InputError>
            </div>
            <div className="flex items-center justify-end mt-4">
                <PrimaryButton className="ms-4" disabled={processing}>
                    Guardar Usuario
                </PrimaryButton>
                <Transition
                    show={recentlySuccessful}
                    enter="transition ease-in-out"
                    enterForm="opacity-0"
                    leave="transition"
                    leaveTo="opacity-0"
                >
                    <p className="text-sm text-gray-600">Usuario Guardado</p>
                </Transition>
            </div>
        </form>
    );
}