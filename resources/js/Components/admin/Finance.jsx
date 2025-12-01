import React from "react";
import { motion } from "framer-motion";

const FinancePage = ({ style, orders, isGlass }) => {
    return (
        <div className="space-y-6 animate-fade-in">
            <h2 className="text-2xl font-bold">Laporan Keuangan</h2>

            <div
                className={`${style.card} p-8 rounded-[30px] relative overflow-hidden`}
            >
                <h3 className="font-bold mb-4">
                    Grafik Pendapatan (Bulan Ini)
                </h3>
                <div className="flex items-end gap-2 h-32">
                    {[40, 60, 30, 80, 50, 90, 70].map((h, i) => (
                        <motion.div
                            key={i}
                            initial={{ height: 0 }}
                            whileInView={{ height: `${h}%` }}
                            className={`flex-1 rounded-t-lg opacity-80 ${
                                isGlass ? "bg-cyan-500" : "bg-[#1e3a8a]"
                            }`}
                        />
                    ))}
                </div>
            </div>

            <div className={`${style.card} p-6 rounded-[30px]`}>
                <h3 className="font-bold mb-4">Riwayat Transaksi</h3>
                <ul className="space-y-4">
                    {orders.map((order) => (
                        <li
                            key={order.id}
                            className={`flex justify-between items-center p-3 rounded-xl ${
                                isGlass ? "bg-white/5" : "bg-slate-50"
                            }`}
                        >
                            <div className="flex items-center gap-3">
                                <div
                                    className={`w-10 h-10 rounded-full flex items-center justify-center ${
                                        isGlass
                                            ? "bg-green-500/20 text-green-400"
                                            : "bg-green-100 text-green-700"
                                    }`}
                                ></div>
                                <div>
                                    <p className="font-bold text-sm">
                                        {order.name}
                                    </p>
                                    <p className={`text-xs ${style.textMuted}`}>
                                        {order.date} • {order.service}
                                    </p>
                                </div>
                            </div>
                            <span className="font-bold text-green-500">
                                + Rp {order.total.toLocaleString()}
                            </span>
                        </li>
                    ))}
                </ul>
            </div>
        </div>
    );
};

export default FinancePage;
