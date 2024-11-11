import TableData from "@/Components/TableData";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { useState } from "react";

export default function VueltasReports({ auth, admin, turnosAsistente }) {
    const [currentPage, setCurrentPage] = useState(1);

    const columns = [
        { name: "Asistente", campo: "Nombre" },
        { name: "Zona", campo: "Zona" },
        { name: "Ruta", campo: "ruta" },
        { name: "Turno", campo: "turno" },
        { name: "Fecha Inicio", campo: "FechaInicio" },
        { name: "Fecha Fin", campo: "FechaFinalizado" },
        {
            name: "Acciones",
            campo: "acciones",
            render: (row) => (
                <button
                    className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                    onClick={() => handleDownload(row.IdTurnoAsistente)}
                >
                    Descargar Reporte
                </button>
            ),
        },
    ];

    const handleDownload = (idTurnoAsistente) => {
        window.location.href = route("exportar.turnoAsistente", idTurnoAsistente);
    };

    return (
        <AuthenticatedLayout
        user = {auth.user}
        admin = {admin}
        header = {
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                Reportes
            </h2>
        }>

        <Head title="Reportes de Vueltas" />

        <div className="p-4 bg-white shadow rounded-lg">
                <TableData
                    totalRows={turnosAsistente.total}
                    columns={columns}
                    data={turnosAsistente.data}
                    perPage={turnosAsistente.per_page}
                    currentPage={currentPage}
                    setCurrentPage={setCurrentPage}
                    titleTable="Lista de Turnos del Asistente"
                />
        </div>

        </AuthenticatedLayout>
    )
}