import React, { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";

const ServicesPage = ({
    style,
    services,
    updatePrice,
    addService,
    deleteService,
    isGlass,
}) => {
    const [showModal, setShowModal] = useState(false);
    const [newData, setNewData] = useState({ name: "", price: "" });

    const handleSubmit = () => {
        if (!newData.name || !newData.price)
            return alert("Mohon isi semua data");
        if (newData.price % 1000 !== 0)
            return alert("Harga harus kelipatan 1000 (Contoh: 5000, 6000)");

        addService({ name: newData.name, price: parseInt(newData.price) });
        setNewData({ name: "", price: "" });
        setShowModal(false);
    };

    return (
        <div className="space-y-6 animate-fade-in">
            <div className="flex justify-between items-center">
                <h2 className="text-2xl font-bold">Kelola Layanan & Harga</h2>
                <button
                    onClick={() => setShowModal(true)}
                    className={`px-6 py-2 rounded-xl font-bold text-sm ${style.btnPrimary}`}
                >
                    + Tambah Layanan
                </button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <AnimatePresence>
                    {services.map((svc) => (
                        <motion.div
                            key={svc.id}
                            initial={{ opacity: 0, scale: 0.9 }}
                            animate={{ opacity: 1, scale: 1 }}
                            exit={{ opacity: 0, scale: 0.9 }}
                            className={`${style.card} p-6 rounded-[30px] flex justify-between items-center group relative`}
                        >
                            <div className="flex-1">
                                <h4 className="font-bold text-lg">
                                    {svc.name}
                                </h4>
                                <p className={`text-xs ${style.textMuted}`}>
                                    Harga per {svc.unit}
                                </p>
                            </div>

                            <div className="flex items-center gap-3">
                                <span className={style.textMuted}>Rp</span>
                                <input
                                    type="number"
                                    step="1000"
                                    value={svc.price}
                                    onChange={(e) =>
                                        updatePrice(svc.id, e.target.value)
                                    }
                                    className={`w-24 p-2 rounded-lg text-right font-bold outline-none border transition-all ${style.input}`}
                                />

                                <button
                                    onClick={() => deleteService(svc.id)}
                                    className={`p-2.5 rounded-lg transition-all duration-200
                                    ${
                                        isGlass
                                            ? "bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white"
                                            : "bg-red-50 text-red-500 hover:bg-red-500 hover:text-white"
                                    }`}
                                    title="Hapus Layanan"
                                >
                                    <svg
                                        className="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        ></path>
                                    </svg>
                                </button>
                            </div>
                        </motion.div>
                    ))}
                </AnimatePresence>
            </div>

            <div className="flex justify-end mt-4">
                <p className={`text-xs italic ${style.textMuted}`}>
                    *Harga otomatis tersimpan saat diketik. Pastikan kelipatan
                    1000.
                </p>
            </div>

            <AnimatePresence>
                {showModal && (
                    <motion.div
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        className="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
                    >
                        <motion.div
                            initial={{ scale: 0.9 }}
                            animate={{ scale: 1 }}
                            exit={{ scale: 0.9 }}
                            className={`w-full max-w-md rounded-[30px] p-8 relative ${
                                isGlass
                                    ? "bg-slate-900 border border-white/20 text-white"
                                    : "bg-white text-slate-800"
                            }`}
                        >
                            <button
                                onClick={() => setShowModal(false)}
                                className="absolute top-4 right-4 text-2xl opacity-50 hover:opacity-100"
                            >
                                ×
                            </button>

                            <h3 className="text-xl font-bold mb-6">
                                Tambah Layanan Baru
                            </h3>

                            <div className="space-y-4">
                                <div>
                                    <label
                                        className={`block text-xs font-bold mb-2 ${style.textMuted}`}
                                    >
                                        Nama Layanan
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="Contoh: Cuci Bedcover"
                                        value={newData.name}
                                        onChange={(e) =>
                                            setNewData({
                                                ...newData,
                                                name: e.target.value,
                                            })
                                        }
                                        className={`w-full p-3 rounded-xl outline-none border ${style.input}`}
                                    />
                                </div>
                                <div>
                                    <label
                                        className={`block text-xs font-bold mb-2 ${style.textMuted}`}
                                    >
                                        Harga per Kg (Kelipatan 1000)
                                    </label>
                                    <input
                                        type="number"
                                        step="1000"
                                        placeholder="Contoh: 8000"
                                        value={newData.price}
                                        onChange={(e) =>
                                            setNewData({
                                                ...newData,
                                                price: e.target.value,
                                            })
                                        }
                                        className={`w-full p-3 rounded-xl outline-none border ${style.input}`}
                                    />
                                </div>
                            </div>

                            <button
                                onClick={handleSubmit}
                                className={`w-full mt-8 py-3 rounded-xl font-bold ${style.btnPrimary}`}
                            >
                                Simpan Layanan
                            </button>
                        </motion.div>
                    </motion.div>
                )}
            </AnimatePresence>
        </div>
    );
};

export default ServicesPage;
