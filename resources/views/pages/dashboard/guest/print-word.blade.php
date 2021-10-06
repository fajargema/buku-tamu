<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Buku Tamu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <button id="btn-export" class="btn btn-primary" onclick="exportHTML();">Download</button>
    </div>
    <div class="container mt-5" id="source-html">
        <h2 class="text-center mb-3"><center>Report Buku Tamu</center></h2>

        <table border="1">
            <thead style="background-color: #000; color:#fff">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Keperluan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->necessity }}</td>
                    <td>{{ $item->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="content-footer">

    </div>


    <script>
        function exportHTML(){
           var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                "xmlns='http://www.w3.org/TR/REC-html40'>"+
                "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
           var footer = "</body></html>";
           var sourceHTML = header+document.getElementById("source-html").innerHTML+footer;

           var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
           var fileDownload = document.createElement("a");
           document.body.appendChild(fileDownload);
           fileDownload.href = source;
           fileDownload.download = 'Buku-Tamu.doc';
           fileDownload.click();
           document.body.removeChild(fileDownload);
        }
    </script>
</body>

</html>
