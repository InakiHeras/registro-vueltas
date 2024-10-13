import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import SelectInput from "@/Components/SelectInput";
import PermissionRouteMapper from "@/Mappers/AdminMappers/PermissionRouteMapper";
import { Transition } from "@headlessui/react";
import { useForm } from "@inertiajs/react";
import { useState, useEffect } from "react";

export default function AddPermission({ permissions }){

    const [loading, setLoading,] = useState(false);
    const [permissionData, setPermissionData] = useState([]);
    
    const { data, setData, post, errors, processing, recentlySuccessful } = useForm({
        code: '',
    });

    useEffect(() => {
        setPermissionData(PermissionRouteMapper(permissions));
    }, [permissions]);

    const submitData = (e) => {
        e.preventDefault();
        setLoading(true);

        post(route('store.permission'), {
            onSuccess: () => {
                reset();
                setLoading(false);
            },
            onError: () => {
                reset();
                setLoading(false);
            }
        });
    }
    
    return (
        <form className="p-4" onSubmit={submitData}>
            <div>
                <h1>Nuevo Permiso</h1>
            </div>
            <div className="mt-2">
                <InputLabel htmlFor="Code" value="Code"/>
                <SelectInput 
                    id="code"
                    type="text"
                    name="code"
                    className="mt-1 block w-full"
                    isFocused={true}
                    options={permissionData}
                    onChange={(e) => setData('code', e.target.value)}
                />
                <InputError message={errors.code}></InputError>
            </div>

            <div className="flex items-center justify-end mt-4">
                <PrimaryButton className="ms-4" disabled={processing}>
                    Guardar Permiso
                </PrimaryButton>
                <Transition
                    show={recentlySuccessful}
                    enter="transition ease-in-out"
                    enterFrom="opacity-0"
                    leave="transition ease-in-out"
                    leaveTo="opacity-0"
                >
                    <p className="text-sm text-gray-600">Permiso Guardado.</p>
                </Transition>
            </div>
        </form>
    )
}