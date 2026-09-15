import cv2
import os
import time

def main():
    cap = cv2.VideoCapture(0)

    if not cap.isOpened():
        print("Error: Tidak dapat mengakses kamera.")
        return

    cap.set(cv2.CAP_PROP_FRAME_WIDTH, 1280)
    cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 720)

    output_dir = "captured_photos"
    if not os.path.exists(output_dir):
        os.makedirs(output_dir)

    print("\n=== APLIKASI KAMERA SIAP ===")
    print(" [S] Tekan sekali -> Single Capture")
    print(" [B] Tahan / Tekan terus -> Burst Capture (Foto beruntun)")
    print(" [Q] Tekan untuk -> Keluar")

    counter = 1
    burst_interval = 0.15 
    last_capture_time = 0

    while True:
        ret, frame = cap.read()
        if not ret:
            print("Gagal membaca frame dari kamera.")
            break

        key = cv2.waitKey(1) & 0xFF

        status_text = "MODE: Normal (S: Single | B: Burst | Q: Keluar)"
        
        # 1. Keluar Aplikasi (Tekan 'q')
        if key == ord('q'):
            print("Menutup aplikasi...")
            break

        # 2. Single Capture (Tekan 's')
        elif key == ord('s'):
            filename = os.path.join(output_dir, f"single_{int(time.time())}_{counter}.jpg")
            cv2.imwrite(filename, frame)
            print(f"[Single Capture] Tersimpan: {filename}")
            counter += 1

        elif key == ord('b'): # burst
            print("[Burst Mode] Memulai burst capture...")
            
            burst_count = 0
            while burst_count < 10:  # Batasi maksimal 10 foto per sekali tahan/tekan agar tidak freeze
                ret_b, frame_b = cap.read()
                if not ret_b:
                    break
                
                cv2.putText(frame_b, f"BURST CAPTURING... ({burst_count+1}/10)", (30, 80), 
                            cv2.FONT_HERSHEY_SIMPLEX, 0.8, (0, 0, 255), 2)
                cv2.imshow("Live Camera Preview - Mac", frame_b)
                
                filename = os.path.join(output_dir, f"burst_{int(time.time())}_{burst_count+1}.jpg")
                cv2.imwrite(filename, frame_b)
                print(f" -> Burst tersimpan: {filename}")
                
                burst_count += 1
                
                cv2.waitKey(int(burst_interval * 1000))
            
            print("[Burst Mode] Selesai.")

        cv2.putText(frame, status_text, (30, 40), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 255, 0), 2)
        cv2.imshow("Live Camera Preview - Mac", frame)

    cap.release()
    cv2.destroyAllWindows()

if __name__ == "__main__":
    main()