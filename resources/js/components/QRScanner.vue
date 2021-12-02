<template>
  <div
    class="h-screen grid place-items-center bg-gradient-to-r from-gray-100 to-indigo-50"
  >
    <div class="max-w-md mx-auto w-full">
      <div
        class="relative bg-white border rounded-lg shadow"
        style="padding-top: 100%"
      >
        <button
          type="button"
          v-if="!(scanning || scanResult)"
          @click="startScanning"
          class="absolute inset-0 w-full h-full grid place-items-center p-4 text-center text-gray-500 hover:text-indigo-500 hover:bg-indigo-50 transition"
        >
          <span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="inline-block h-12 w-12"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"
              />
            </svg>
            <span class="mt-2 block text-xl font-bold">Start Scanning</span>
          </span>
        </button>
        <video
          v-else-if="scanning"
          ref="scanner"
          class="absolute inset-0 w-full h-full border"
        ></video>
        <div
          v-else-if="scanResult"
          class="text-center absolute inset-0 grid place-items-center"
        >
          <div>
            <p class="font-bold">Scan result</p>
            <p class="text-xl mt-2">{{ scanResult }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import QrScanner from "qr-scanner";
import QrScannerWorkerPath from "!!file-loader!../../../node_modules/qr-scanner/qr-scanner-worker.min.js";

QrScanner.WORKER_PATH = QrScannerWorkerPath;

export default {
  data() {
    return {
      scannerObj: null,
      scanning: false,
      scanResult: "",
    };
  },

  beforeDestroy() {
    if (this.scannerObj) {
      this.scannerObj.destroy();
      this.scannerObj = null;
    }
  },

  methods: {
    startScanning() {
      this.scanning = true;

      this.$nextTick(() => {
        this.scannerObj = new QrScanner(this.$refs.scanner, (result) => {
          this.scanResult = result;
            // optional
            axios
              .post("/scan-result", { result })
              .then((response) => console.log(response.data))
              .catch((err) => console.log("error sending scan result"));

          this.endScanning();
        });

        this.scannerObj.start();
      });
    },

    endScanning() {
      this.scanning = false;

      if (this.scannerObj) {
        this.scannerObj.stop();
      }
    },
  },
};
</script>
