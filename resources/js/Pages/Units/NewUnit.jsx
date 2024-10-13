import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Transition } from "@headlessui/react";
import { useForm } from "@inertiajs/react";
import { QRCodeCanvas } from "qrcode.react"; // Importa QRCodeCanvas
import { useRef, useEffect } from "react";

export default function NewUnit() {
    const { data, setData, post, errors, processing, recentlySuccessful } =
        useForm({
            Unidad: "",
            qrImage: "",
        });

    const qrRef = useRef(null); // Referencia para el canvas del QR
    
    useEffect(() => {
        const canvas = qrRef.current;
        if (canvas) {
            const qrImage = canvas.toDataURL(); // Obtén la imagen en formato base64
            setData("qrImage", qrImage); // Actualiza el estado con la imagen
        }
    }, [data.Unidad]);

    const submit = (e) => {
        e.preventDefault();
        post("/units", {
            onSuccess: () => {
                setData({ Unidad: "", qrImage: "" }); // Reiniciar los campos
            },
        });
    };

    return (
        <form className="p-4" onSubmit={submit}>
            <div>
                <h1>Agregar nueva unidad</h1>
            </div>
            <div className="mt-2">
                <InputLabel htmlFor="numeroUnidad" value="Número de Unidad" />
                <TextInput
                    id="Unidad"
                    name="Unidad"
                    type="number"
                    value={data.Unidad}
                    className="mt-2 block w-full"
                    onChange={(e) => setData("Unidad", e.target.value)}
                    required
                    isFocused
                />
                <InputError message={errors.Unidad}></InputError>
            </div>
            <div className="mt-4">
                <InputLabel value="Código QR" />
                <div>
                    <QRCodeCanvas
                        ref={qrRef} // Añade la referencia al canvas
                        value={JSON.stringify({ Unidad: data.Unidad })}
                        size={300}
                    />
                </div>
            </div>
            <div className="flex items-center justify-end mt-4">
                <PrimaryButton className="ms-4" disabled={processing}>
                    Guardar Unidad
                </PrimaryButton>
                <Transition
                    show={recentlySuccessful}
                    enter="transition ease-in-out"
                    enterForm="opacity-0"
                    leave="transition"
                    leaveTo="opacity-0"
                >
                    <p className="text-sm text-gray-600">Unidad Guardada</p>
                </Transition>
            </div>
        </form>
    );
}
