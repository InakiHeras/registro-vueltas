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
}) => {
    // Configuración para los botones de paginación
    const pageButtons = [];
    const totalPages = Math.ceil(totalRows / perPage);
    const maxPageButtons = 5;
    
    // Cálculo de las páginas inicial y final
    let startPage = Math.max(1, currentPage - Math.floor(maxPageButtons / 2));
    let endPage = Math.min(totalPages, currentPage + Math.floor(maxPageButtons / 2));

    // Ajuste de los botones de inicio y fin
    if (endPage - startPage + 1 < maxPageButtons) {
        if (startPage === 1) {
            endPage = Math.min(totalPages, endPage + (maxPageButtons - (endPage - startPage + 1)));
        } else {
            startPage = Math.max(1, startPage - (maxPageButtons - (endPage - startPage + 1)));
        }
    }

    // Botón para la primera página y elipsis
    if (startPage > 1) {
        pageButtons.push(
            <button key="1" className={`button ${currentPage === 1 ? "active" : ""}`} onClick={() => setCurrentPage(1)}>
                1
            </button>
        );
        if (startPage > 2) pageButtons.push(<span key="ellipsis-start">...</span>);
    }

    // Botones de páginas intermedias
    for (let i = startPage; i <= endPage; i++) {
        pageButtons.push(
            <button key={i} className={`button ${i === currentPage ? "active" : ""}`} onClick={() => setCurrentPage(i)}>
                {i}
            </button>
        );
    }

    // Botón para la última página y elipsis
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) pageButtons.push(<span key="ellipsis-end">...</span>);
        pageButtons.push(
            <button key={totalPages} className={`button ${currentPage === totalPages ? "active" : ""}`} onClick={() => setCurrentPage(totalPages)}>
                {totalPages}
            </button>
        );
    }

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
                                <button className="button" onClick={() => setCurrentPage(currentPage - 1)} disabled={currentPage === 1}>
                                    Anterior
                                </button>
                                {pageButtons}
                                <button className="button" onClick={() => setCurrentPage(currentPage + 1)} disabled={currentPage >= totalPages}>
                                    Siguiente
                                </button>
                            </div>
                            <small>
                                Total de registros: {totalRows} - Página {currentPage} de {totalPages}
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
};

export default TableData;
