@extends('layouts.default')

@push('css')
    <style>
        .bg-duplicated > td {
            background-color: yellow !important;
        }

        .tx-duplicated {
            color: red;
        }
    </style>
@endpush

@section('content')
<div class="card" x-data="form">
    <div class="card-header">
        <h3 class="card-title">DTHRTH</h3>
    </div>
    <div class="card-body">
        <form @submit.prevent="submit()">
            <fieldset :disabled="loading">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Bulan Tahun</label>
                            <input type="text" class="form-control" id="bulan_tahun" readonly>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label>Tanggal Upload</label>
                            <input type="text" class="form-control" id="tanggal_upload" readonly>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>Berkas</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" :class="hasAnyError(form, 'berkas') && 'is-invalid'" placeholder="Berkas" id="berkas">
                                <span class="error invalid-feedback" x-text="`${getFormError(form, 'berkas')}`"></span>
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </fieldset>
        </form>

        <div class="row mb-3">
            <div class="col-12">
                <div class="col-6">
                    <div class="form-group">
                        <label>Duplikasi?</label>
                        <select class="form-control" id="duplikasi">
                            <option value="">Semua</option>
                            <option value="ya">Ya</option>
                            <option value="tidak">Tidak</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <table id="tabel" class="table table-sm" style="width: 100%">
            <thead>
                <tr>
                    <th>no</th>
                    <th>no_spm</th>
                    <th>nilai_spm</th>
                    <th>tanggal_spm</th>
                    <th>no_sp2d</th>
                    <th>nilai_sp2d</th>
                    <th>tanggal_sp2d</th>
                    <th>kode_akun_belanja</th>
                    <th>kode_akun_pajak</th>
                    <th>ppn</th>
                    <th>pph21</th>
                    <th>pph22</th>
                    <th>pph23</th>
                    <th>pph4_2</th>
                    <th>jumlah</th>
                    <th>npwp</th>
                    <th>nama</th>
                    <th>kode_billing</th>
                    <th>ntpn</th>
                    <th>ket</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="card-footer">
        <a href="/dthrth"><button type="button" class="btn btn-secondary">Kembali</button></a>
    </div>
</div>

<div class="modal fade" id="modalDuped">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Data Duplikat</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 mb-3">
                    <p>Tabel Data</p>
                    <div class="table-responsive">
                        <table id="tabel-duped-source" class="table table-sm" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>SKPD</th>
                                    <th>Bulan/Tahun</th>
                                    <th>Tanggal Upload</th>
                                    <th>no</th>
                                    <th>no_spm</th>
                                    <th>nilai_spm</th>
                                    <th>tanggal_spm</th>
                                    <th>no_sp2d</th>
                                    <th>nilai_sp2d</th>
                                    <th>tanggal_sp2d</th>
                                    <th>kode_akun_belanja</th>
                                    <th>kode_akun_pajak</th>
                                    <th>ppn</th>
                                    <th>pph21</th>
                                    <th>pph22</th>
                                    <th>pph23</th>
                                    <th>pph4_2</th>
                                    <th>jumlah</th>
                                    <th>npwp</th>
                                    <th>nama</th>
                                    <th>kode_billing</th>
                                    <th>ntpn</th>
                                    <th>ket</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    <p>Tabel Data Duplikat</p>
                    <div class="table-responsive">
                        <table id="tabel-duped" class="table table-sm" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>SKPD</th>
                                    <th>Bulan/Tahun</th>
                                    <th>Tanggal Upload</th>
                                    <th>no</th>
                                    <th>no_spm</th>
                                    <th>nilai_spm</th>
                                    <th>tanggal_spm</th>
                                    <th>no_sp2d</th>
                                    <th>nilai_sp2d</th>
                                    <th>tanggal_sp2d</th>
                                    <th>kode_akun_belanja</th>
                                    <th>kode_akun_pajak</th>
                                    <th>ppn</th>
                                    <th>pph21</th>
                                    <th>pph22</th>
                                    <th>pph23</th>
                                    <th>pph4_2</th>
                                    <th>jumlah</th>
                                    <th>npwp</th>
                                    <th>nama</th>
                                    <th>kode_billing</th>
                                    <th>ntpn</th>
                                    <th>ket</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('js')
<script>
var dthrth = {{ Js::from($dthrth) }}

document.addEventListener('alpine:init', () => {
    Alpine.data('form', () => ({
        loading: false,

        form: {
            bulan: {value: dthrth.bulan, errors: []},
            tahun: {value: dthrth.tahun, errors: []},
            berkas: {value: '', errors: []},
        },

        async check() {
            let response = await axios.post('/dthrth/check', {
                bulan: this.form.bulan.value,
                tahun: this.form.tahun.value,
            })

            if (response.data) {
                let result = await Swal.fire({
                    title: "Data sudah ada",
                    text: "Anda yakin ingin mengganti data yang sudah ada ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, ganti data"
                })

                return result.isConfirmed
            }

            return true
        },

        async submit() {
            if (await this.check()) {
                var that = this

                this.loading = true

                let form = formValue(this.form, 'POST')

                form.set('berkas', document.getElementById('berkas').files[0])

                axios.post('/dthrth', form)
                .then(function (response) {
                    resetFormErrors(that.form)

                    storeNotif({type: 'success', message: `Berhasil upload data`})

                    window.location = `/dthrth/${response.data.id}`
                })
                .catch(function (error) {
                    switch (error.response.status) {
                        case 422:
                            resetFormErrors(that.form)

                            setFormError(that.form, error)
                            break;

                        default:
                            break;
                    }
                })
                .finally(function () {
                    that.loading = false
                });
            }
        },
    }))
})

$("#duplikasi").change(function() {
    $('#tabel').DataTable().ajax.reload()
});

$(function() {
    $("#bulan_tahun").val(dthrth.bulan_tahun)
    $("#tanggal_upload").val(dthrth.uploaded_at)

    $('#tabel').DataTable( {
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: `/dthrth/datatableLihat`,
            type: 'POST',
            data: function (d) {
                d.dthrth_id = dthrth.id;
                d.duplikasi = $("#duplikasi").val();
            }
        },
        columns: [
            {data: 'no', name: 'r.no'},
            {data: 'no_spm', name: 'r.no_spm'},
            {data: 'nilai_spm', name: 'r.nilai_spm'},
            {data: 'tanggal_spm', name: 'r.tanggal_spm'},
            {data: 'no_sp2d', name: 'r.no_sp2d'},
            {data: 'nilai_sp2d', name: 'r.nilai_sp2d'},
            {data: 'tanggal_sp2d', name: 'r.tanggal_sp2d'},
            {data: 'kode_akun_belanja', name: 'r.kode_akun_belanja'},
            {data: 'kode_akun_pajak', name: 'r.kode_akun_pajak'},
            {data: 'ppn', name: 'r.ppn'},
            {data: 'pph21', name: 'r.pph21'},
            {data: 'pph22', name: 'r.pph22'},
            {data: 'pph23', name: 'r.pph23'},
            {data: 'pph4_2', name: 'r.pph4_2'},
            {data: 'jumlah', name: 'r.jumlah'},
            {data: 'npwp', name: 'r.npwp'},
            {data: 'nama', name: 'r.nama'},
            {data: 'kode_billing', name: 'r.kode_billing'},
            {data: 'ntpn', name: 'r.ntpn'},
            {data: 'ket', name: 'r.ket'},
        ],
        drawCallback: async function (settings) {
            var api = this.api();

            let datas = api.rows({ page: 'current' }).data()

            let ntpns = []
            let kode_billings = []

            for (let index = 0; index < datas.length; index++) {
                const node = datas.row(`:eq(${index})`).node()
                const data = datas.row(`:eq(${index})`).data()

                kode_billings.push(data.kode_billing)
                ntpns.push(data.ntpn)

                if (data.duplikat) {
                    $(node).click(async function() {
                        let res = await axios.post('/dthrth/listDuped', {ntpn: data.ntpn, kode_billing: data.kode_billing, excluded_id: data.id})
                        let resData = res.data

                        // Fill Tabel Source Data
                        $("#tabel-duped-source > tbody")[0].innerHTML = ''
                        let tbodyRef = $("#tabel-duped-source > tbody")[0]
                        let newRow = tbodyRef.insertRow();
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.dthrth.skpd.skpd));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.dthrth.bulan_tahun));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.dthrth.uploaded_at));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.no));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.no_spm));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.nilai_spm));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.tanggal_spm));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.no_sp2d));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.nilai_sp2d));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.tanggal_sp2d));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.kode_akun_belanja));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.kode_akun_pajak));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.ppn));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.pph21));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.pph22));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.pph23));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.pph4_2));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.jumlah));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.npwp));
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.nama));
                        let cell = newRow.insertCell()
                        cell.appendChild(document.createTextNode(resData.dthrth.kode_billing))
                        if(resData.dupedList.filter(d => d.kode_billing == resData.dthrth.kode_billing).length) {
                            cell.classList.add('tx-duplicated')
                        }
                        cell = newRow.insertCell()
                        cell.appendChild(document.createTextNode(resData.dthrth.ntpn))
                        if(resData.dupedList.filter(d => d.ntpn == resData.dthrth.ntpn).length) {
                            cell.classList.add('tx-duplicated')
                        }
                        newRow.insertCell().appendChild(document.createTextNode(resData.dthrth.ket));

                        // Fill Tabel Duped Data
                        $("#tabel-duped > tbody")[0].innerHTML = ''
                        tbodyRef = $("#tabel-duped > tbody")[0]
                        for (let index = 0; index < resData.dupedList.length; index++) {
                            const element = resData.dupedList[index];

                            newRow = tbodyRef.insertRow();
                            newRow.insertCell().appendChild(document.createTextNode(element.dthrth.skpd.skpd));
                            newRow.insertCell().appendChild(document.createTextNode(element.dthrth.bulan_tahun));
                            newRow.insertCell().appendChild(document.createTextNode(element.dthrth.uploaded_at));
                            newRow.insertCell().appendChild(document.createTextNode(element.no));
                            newRow.insertCell().appendChild(document.createTextNode(element.no_spm));
                            newRow.insertCell().appendChild(document.createTextNode(element.nilai_spm));
                            newRow.insertCell().appendChild(document.createTextNode(element.tanggal_spm));
                            newRow.insertCell().appendChild(document.createTextNode(element.no_sp2d));
                            newRow.insertCell().appendChild(document.createTextNode(element.nilai_sp2d));
                            newRow.insertCell().appendChild(document.createTextNode(element.tanggal_sp2d));
                            newRow.insertCell().appendChild(document.createTextNode(element.kode_akun_belanja));
                            newRow.insertCell().appendChild(document.createTextNode(element.kode_akun_pajak));
                            newRow.insertCell().appendChild(document.createTextNode(element.ppn));
                            newRow.insertCell().appendChild(document.createTextNode(element.pph21));
                            newRow.insertCell().appendChild(document.createTextNode(element.pph22));
                            newRow.insertCell().appendChild(document.createTextNode(element.pph23));
                            newRow.insertCell().appendChild(document.createTextNode(element.pph4_2));
                            newRow.insertCell().appendChild(document.createTextNode(element.jumlah));
                            newRow.insertCell().appendChild(document.createTextNode(element.npwp));
                            newRow.insertCell().appendChild(document.createTextNode(element.nama));
                            let cell = newRow.insertCell()
                            cell.appendChild(document.createTextNode(element.kode_billing))
                            if(resData.dupedList.filter(d => d.kode_billing == resData.dthrth.kode_billing).length) {
                                cell.classList.add('tx-duplicated')
                            }
                            cell = newRow.insertCell()
                            cell.appendChild(document.createTextNode(element.ntpn))
                            if(resData.dupedList.filter(d => d.ntpn == resData.dthrth.ntpn).length) {
                                cell.classList.add('tx-duplicated')
                            }
                            newRow.insertCell().appendChild(document.createTextNode(element.ket));
                        }

                        $("#modalDuped").modal()
                    })

                    node.classList.add("bg-duplicated");
                }
            }

            let res = await axios.post('/dthrth/checkDuplikat', {ntpns, kode_billings})
            let resData = res.data

            for (let index = 0; index < datas.length; index++) {
                const node = datas.row(`:eq(${index})`).node()
                const data = datas.row(`:eq(${index})`).data()

                const node_kode_billing = $("td:eq(17)", node)[0]
                const node_ntpn = $("td:eq(18)", node)[0]

                if (resData.dupedNtpns.includes(data.ntpn)) {
                    node_ntpn.classList.add("tx-duplicated");
                }
                if (resData.dupedKodeBillings.includes(data.kode_billing)) {
                    node_kode_billing.classList.add("tx-duplicated");
                }
            }
        },
    } );
});
</script>
@endpush
