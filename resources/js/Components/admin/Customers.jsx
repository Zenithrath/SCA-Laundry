import React, { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";

const CustomersPage = ({ style, isGlass, orders, updateStatus }) => {
    const [selectedOrder, setSelectedOrder] = useState(null);

    const handleStatusChange = (status) => {
        updateStatus(selectedOrder.id, status);
        setSelectedOrder({ ...selectedOrder, status: status });
    };

    const getWhatsAppLink = (phone, name, orderId) => {
        if (!phone) return "#";

        let number = phone.toString().replace(/\D/g, "");

        if (number.startsWith("0")) {
            number = "62" + number.substring(1);
        }

        const message = `Halo Kak ${name}, update mengenai pesanan Laundry #${orderId}. Status saat ini: Sedang diproses. Terima kasih!`;

        return `https://wa.me/${number}?text=${encodeURIComponent(message)}`;
    };

    return (
        <div className="space-y-6 animate-fade-in">
            <h2 className="text-2xl font-bold">Data Pesanan Pelanggan</h2>
            <p className={`text-sm ${style.textMuted}`}>
                Klik pada baris pelanggan untuk melihat detail & chat WhatsApp.
            </p>

            <div className={`${style.card} rounded-[30px] overflow-hidden`}>
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-sm">
                        <thead
                            className={
                                isGlass
                                    ? "bg-white/5 border-b border-white/10"
                                    : "bg-blue-50 border-b border-blue-100"
                            }
                        >
                            <tr>
                                <th className="p-4">Order ID</th>
                                <th className="p-4">Nama & Tanggal</th>
                                <th className="p-4">Layanan</th>
                                <th className="p-4">Status</th>
                                <th className="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {orders.map((order) => (
                                <tr
                                    key={order.id}
                                    onClick={() => setSelectedOrder(order)}
                                    className={`cursor-pointer border-b transition-colors ${
                                        isGlass
                                            ? "border-white/5 hover:bg-white/5"
                                            : "border-slate-50 hover:bg-blue-50"
                                    }`}
                                >
                                    <td className="p-4 font-bold">
                                        {order.id}
                                    </td>
                                    <td className="p-4">
                                        <p className="font-semibold">
                                            {order.name}
                                        </p>
                                        <p
                                            className={`text-xs ${style.textMuted}`}
                                        >
                                            {order.date}
                                        </p>
                                    </td>
                                    <td className="p-4">{order.service}</td>
                                    <td className="p-4">
                                        <span
                                            className={`px-3 py-1 rounded-full text-xs font-bold 
                                            ${
                                                order.status === "Selesai"
                                                    ? "bg-green-100 text-green-700"
                                                    : order.status ===
                                                      "Menunggu"
                                                    ? "bg-red-100 text-red-700"
                                                    : "bg-yellow-100 text-yellow-700"
                                            }`}
                                        >
                                            {order.status}
                                        </span>
                                    </td>
                                    <td className="p-4 text-right text-blue-500 font-bold text-xs">
                                        Detail &gt;
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>

            <AnimatePresence>
                {selectedOrder && (
                    <motion.div
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        className="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
                    >
                        <motion.div
                            initial={{ scale: 0.9, y: 20 }}
                            animate={{ scale: 1, y: 0 }}
                            exit={{ scale: 0.9, y: 20 }}
                            className={`w-full max-w-2xl rounded-[30px] p-8 relative overflow-y-auto max-h-[90vh] ${
                                isGlass
                                    ? "bg-slate-900 border border-white/20 text-white"
                                    : "bg-white text-slate-800 shadow-2xl"
                            }`}
                        >
                            <button
                                onClick={() => setSelectedOrder(null)}
                                className="absolute top-6 right-6 text-2xl opacity-50 hover:opacity-100 transition"
                            >
                                ×
                            </button>

                            <h3 className="text-2xl font-bold mb-1">
                                Detail Pesanan
                            </h3>
                            <div className="flex items-center gap-3 mb-6">
                                <span
                                    className={`text-sm font-mono px-2 py-1 rounded ${
                                        isGlass ? "bg-white/10" : "bg-gray-100"
                                    }`}
                                >
                                    {selectedOrder.id}
                                </span>
                                <span
                                    className={`text-xs px-2 py-1 rounded-full ${
                                        selectedOrder.status === "Selesai"
                                            ? "bg-green-100 text-green-700"
                                            : "bg-yellow-100 text-yellow-800"
                                    }`}
                                >
                                    {selectedOrder.status}
                                </span>
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div className="space-y-5">
                                    <div>
                                        <label
                                            className={`text-xs font-bold uppercase tracking-wider ${style.textMuted}`}
                                        >
                                            Pelanggan
                                        </label>
                                        <p className="font-bold text-lg">
                                            {selectedOrder.name}
                                        </p>
                                        <p className="text-sm">
                                            {selectedOrder.phone}
                                        </p>

                                        <a
                                            href={getWhatsAppLink(
                                                selectedOrder.phone,
                                                selectedOrder.name,
                                                selectedOrder.id
                                            )}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="inline-flex items-center gap-2 mt-3 px-4 py-2 bg-green-500 text-white rounded-lg text-xs font-bold hover:bg-green-600 transition shadow-lg shadow-green-500/30 w-full justify-center"
                                        >
                                            <svg
                                                className="w-4 h-4"
                                                fill="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                            </svg>
                                            Chat WhatsApp
                                        </a>
                                    </div>

                                    <div>
                                        <label
                                            className={`text-xs font-bold uppercase tracking-wider ${style.textMuted}`}
                                        >
                                            Lokasi Penjemputan
                                        </label>
                                        <div
                                            className={`p-3 rounded-xl mt-1 text-sm leading-relaxed ${
                                                isGlass
                                                    ? "bg-white/10"
                                                    : "bg-gray-50"
                                            }`}
                                        >
                                            {selectedOrder.address ||
                                                "Tidak ada data alamat"}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            className={`text-xs font-bold uppercase tracking-wider ${style.textMuted}`}
                                        >
                                            Waktu Jemput
                                        </label>
                                        <div className="flex gap-4 mt-1">
                                            <div
                                                className={`flex-1 p-3 rounded-xl text-sm ${
                                                    isGlass
                                                        ? "bg-white/10"
                                                        : "bg-gray-50"
                                                }`}
                                            >
                                                📅{" "}
                                                {selectedOrder.pickup_date ||
                                                    "-"}
                                            </div>
                                            <div
                                                className={`flex-1 p-3 rounded-xl text-sm ${
                                                    isGlass
                                                        ? "bg-white/10"
                                                        : "bg-gray-50"
                                                }`}
                                            >
                                                ⏰{" "}
                                                {selectedOrder.pickup_time ||
                                                    "-"}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div className="space-y-5">
                                    <div
                                        className={`p-5 rounded-2xl ${
                                            isGlass
                                                ? "bg-blue-900/30 border border-blue-500/30"
                                                : "bg-blue-50 border border-blue-100"
                                        }`}
                                    >
                                        <h4 className="font-bold mb-3 text-blue-500">
                                            Rincian Biaya
                                        </h4>
                                        <div className="space-y-2 text-sm">
                                            <div className="flex justify-between">
                                                <span>Layanan</span>
                                                <span>
                                                    {selectedOrder.service}
                                                </span>
                                            </div>
                                            <div className="flex justify-between">
                                                <span>Berat</span>
                                                <span>
                                                    {selectedOrder.weight}
                                                </span>
                                            </div>
                                            <div className="border-t border-dashed border-blue-300 my-2"></div>
                                            <div className="flex justify-between font-bold text-lg">
                                                <span>Total</span>
                                                <span>
                                                    Rp{" "}
                                                    {selectedOrder.total.toLocaleString()}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            className={`text-xs font-bold uppercase tracking-wider block mb-2 ${style.textMuted}`}
                                        >
                                            Update Status
                                        </label>
                                        <div className="grid grid-cols-2 gap-2">
                                            {[
                                                "Menunggu",
                                                "Dicuci",
                                                "Disetrika",
                                                "Selesai",
                                            ].map((status) => (
                                                <button
                                                    key={status}
                                                    onClick={() =>
                                                        handleStatusChange(
                                                            status
                                                        )
                                                    }
                                                    className={`px-3 py-2 rounded-lg text-xs font-bold border transition-all
                                                    ${
                                                        selectedOrder.status ===
                                                        status
                                                            ? isGlass
                                                                ? "bg-cyan-600 border-cyan-500 text-white"
                                                                : "bg-blue-600 border-blue-600 text-white"
                                                            : isGlass
                                                            ? "border-white/10 bg-white/5 hover:bg-white/10"
                                                            : "border-slate-200 hover:bg-slate-100 text-slate-600"
                                                    }`}
                                                >
                                                    {status}
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button
                                onClick={() => setSelectedOrder(null)}
                                className={`w-full mt-8 py-4 rounded-xl font-bold text-sm ${style.btnPrimary}`}
                            >
                                Simpan Perubahan & Tutup
                            </button>
                        </motion.div>
                    </motion.div>
                )}
            </AnimatePresence>
        </div>
    );
};

export default CustomersPage;
