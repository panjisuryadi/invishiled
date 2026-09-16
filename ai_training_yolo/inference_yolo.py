import glob
import os
import cv2
from ultralytics import YOLO

def main():
    # Load model dari hasil training terakhir
    model = YOLO('runs/detect/train-22/weights/best.pt')

    search_pattern = 'archive/**/train/*.jpg'
    found_images = glob.glob(search_pattern, recursive=True)

    if not found_images:
        print("Error: Tidak ditemukan file gambar .jpg di dalam folder 'archive'.")
        print("Pastikan struktur folder dataset Anda sudah benar.")
        return

    # Ambil gambar pertama yang ditemukan
    image_path = found_images[0]
    print(f"Menggunakan gambar: {image_path}")

    # Baca gambar menggunakan OpenCV
    img = cv2.imread(image_path)
    if img is None:
        print(f"Error: Gagal membaca file gambar dari {image_path}")
        return

    results = model(img)

    annotated_frame = results[0].plot()

    print("Menampilkan pop-up window... Tekan tombol apa saja pada keyboard untuk menutup jendela.")
    while True:
        cv2.imshow("YOLO Fruit Detection Result", annotated_frame)
        
        # Keluar saat ada tombol keyboard yang ditekan
        if cv2.waitKey(1) != -1:
            break

    cv2.destroyAllWindows()

if __name__ == '__main__':
    main()