# -*- coding: utf-8 -*-
import csv
import time

import cognitive_face as CF
import requests
import scipy.misc
import urllib3
from picamera import PiCamera
from picamera.array import PiRGBArray

auth = ('...', '...')


def main():
    camera = PiCamera()
    rawCapture = PiRGBArray(camera)
    time.sleep(0.1)
    urllib3.disable_warnings()

    KEY = '...'
    CF.Key.set(KEY)
    # If you need to, you can change your base API url with:
    # CF.BaseUrl.set('https://westcentralus.api.cognitive.microsoft.com/face/v1.0/')

    BASE_URL = 'https://eastus.api.cognitive.microsoft.com/face/v1.0/'  # Replace with your regional Base URL
    CF.BaseUrl.set(BASE_URL)

    # capture frames from the camera
    for frame in camera.capture_continuous(rawCapture, format="rgb",
                                           use_video_port=True):
        starttime = time.time()
        # grab the raw NumPy array representing the image - this array
        # will be 3D, representing the width, height, and # of channels
        image = frame.array

        scipy.misc.imsave('outfile.jpg', image)

        faces = CF.face.detect('outfile.jpg',
                               attributes='age,gender,emotion,glasses')

        result = requests.get('https://52.170.239.208/get_customers.php',
                              auth=auth, verify='./cert.crt')
        assert result.status_code == 200

        # int custid, text faceid, int thief
        existing_users = list(csv.reader(result.text.splitlines(False)))
        for face in faces:
            found_face = False
            for user in existing_users:
                verify_value = CF.face.verify(user[1], face['faceId'])
                print(user[1], face['faceId'], verify_value)
                if verify_value['isIdentical']:
                    found_face = True
                    print("found user, ", face)
                    result = requests.post(
                        'https://52.170.239.208/add_interaction.php',
                        json={
                            'custID': str(user[0]),
                            'faceID': face['faceId'],
                            'happiness': face['faceAttributes']['emotion'][
                                'happiness'],
                            'gender': 1 if face['faceAttributes'][
                                               'gender'] == 'male' else 0,
                            'age': face['faceAttributes']['age'],
                            'glasses': face['faceAttributes']['glasses'],
                        }, auth=auth, verify='./cert.crt')
                    assert result.status_code == 200
                    break

            if not found_face:
                print("new face!")
                result = requests.post(
                    'https://52.170.239.208/add_customer.php',
                    json={'faceID': face['faceId']},
                    auth=auth, verify='./cert.crt')
                assert result.status_code == 200

        # clear the stream in preparation for the next frame
        rawCapture.truncate(0)

        duration = time.time() - starttime
        time.sleep(max(2 - duration, 0))


if __name__ == '__main__':
    main()
