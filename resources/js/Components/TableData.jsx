import React from "react";
import PropTypes from "prop-types";
import ProgressBar from "@/Components/ProgressBar";

const TableData = ({
    totalRows,
    columns = [],
    data = [],
    perPage,
    currentPage,
    setCurrentPage,
    loading,
    titleTable,
    classIcon,
    renderActions,
    links,
}) => {
    // Configuración para los botones de paginación
    const pageButtons = links.map((link, index) => {
        if (!link.url) {
            return <span key={index} dangerouslySetInnerHTML={{ __html: link.label }} />;
        }
    
        return (
            <button
                key={index}
                className={`button ${link.active ? "active" : ""}`}
                onClick={() => window.location.href = link.url}
                dangerouslySetInnerHTML={{ __html: link.label }}
            />
        );
    });

    return (
        <div className="w-full">
            <div className="card has-table shadow-lg p-2">
                <header className="card-header">
                    {loading ? (
                        <>
                            <ProgressBar />
                            <p className="card-header-title">Cargando datos...</p>
                        </>
                    ) : (
                        <p className="card-header-title">
                            <span className="icon"><i className={classIcon}></i></span>
                            {titleTable}
                        </p>
                    )}
                </header>
                <div className="card-content">
                    <table>
                        <thead>
                            <tr>
                                {columns.map((col, i) => (
                                    <th key={i}> {col.name} </th>
                                ))}
                                {renderActions && <th>Acciones</th>}
                            </tr>
                        </thead>
                        <tbody>
                            {data.length > 0 ? (
                                data.map((row) => (
                                    <tr key={row.id}>
                                        {columns.map((col, j) => (
                                            <td key={j} data-label={col.campo}>
                                                {col.render ? col.render(row) : row[col.campo]}
                                            </td>
                                        ))}
                                        {renderActions && (
                                            <td className="actions-cell">
                                                <div className="buttons right nowrap">
                                                    {renderActions(row)}
                                                </div>
                                            </td>
                                        )}
                                    </tr>
                                ))
                            ) : (
                                <tr><td colSpan={columns.length + (renderActions ? 1 : 0)} className="text-center">No hay datos disponibles</td></tr>
                            )}
                        </tbody>
                    </table>
                    <div className="table-pagination">
                        <div className="flex items-center justify-between">
                            <div className="buttons">
                                {pageButtons}
                            </div>
                            <small>
                                Total de registros: {totalRows} - Página {currentPage} de {Math.ceil(totalRows / perPage)}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

// Validación de tipos para los props
TableData.propTypes = {
    totalRows: PropTypes.number.isRequired,
    columns: PropTypes.array.isRequired,
    data: PropTypes.array.isRequired,
    perPage: PropTypes.number.isRequired,
    currentPage: PropTypes.number.isRequired,
    setCurrentPage: PropTypes.func.isRequired,
    loading: PropTypes.bool,
    titleTable: PropTypes.string,
    classIcon: PropTypes.string,
    renderActions: PropTypes.func,
    links: PropTypes.array.isRequired,  // Agregar links como propiedad requerida
};

export default TableData;
