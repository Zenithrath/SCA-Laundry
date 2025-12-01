import React from "react";

const DashboardPage = ({ style, orders, isGlass }) => {
    const unfinished = orders.filter((o) => o.status !== "Selesai").length;
    const income = orders.reduce((acc, curr) => acc + curr.total, 0);

    return (
        <div className="space-y-6 animate-fade-in">
            <h2 className="text-2xl font-bold">Dashboard Overview</h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div className={`${style.card} p-6 rounded-[30px]`}>
                    <p
                        className={`text-xs uppercase font-bold ${style.textMuted}`}
                    >
                        Pesanan Belum Selesai
                    </p>
                    <h3 className="text-4xl font-bold mt-2 text-orange-500">
                        {unfinished}
                    </h3>
                    <p className="text-xs mt-2">Perlu tindakan segera</p>
                </div>
                <div className={`${style.card} p-6 rounded-[30px]`}>
                    <p
                        className={`text-xs uppercase font-bold ${style.textMuted}`}
                    >
                        Total Pendapatan
                    </p>
                    <h3 className="text-4xl font-bold mt-2 text-green-500">
                        Rp {income.toLocaleString()}
                    </h3>
                    <p className="text-xs mt-2">Akumulasi semua order</p>
                </div>
                <div className={`${style.card} p-6 rounded-[30px]`}>
                    <p
                        className={`text-xs uppercase font-bold ${style.textMuted}`}
                    >
                        Total Pelanggan
                    </p>
                    <h3
                        className={`text-4xl font-bold mt-2 ${
                            isGlass ? "text-cyan-400" : "text-blue-600"
                        }`}
                    >
                        {orders.length}
                    </h3>
                    <p className="text-xs mt-2">User terdaftar</p>
                </div>
            </div>
        </div>
    );
};

export default DashboardPage;
